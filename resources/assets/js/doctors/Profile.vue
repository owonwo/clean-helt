<template>
  <section>
    <ProfileGrid 
      :avatar="user.avatar"
      :name="`Dr. ${user.first_name}`"
      avatar-url="/api/doctors/avatar">
      <nav slot="navigation">
        <li><a href="#">Basic Information</a></li>
        <li v-if="isDoctor()"><a href="#">Hospitals</a></li>
        <li v-if="isHospital()"><a href="#assigned-patients">Assigned Patients</a></li>
      </nav>

      <template slot-scope="pager">
        <pager :current="pager.page">
          <section 
            slot="p1"
            class="column">
            <div class="menu-label">Basic Information</div>
            <table class="table is-fullwidth">
              <tr>
                <th width="20%">Full Name:</th>
                <td>{{ [user.first_name, user.middle_name, user.last_name].join(' ') }}</td>
              </tr>
              <tr>
                <th>Specialization:</th>
                <td>{{ user.specialization | ucfirst }}</td>
              </tr>
              <tr>
                <th>Email:</th>
                <td>{{ user.email }}</td>
              </tr>
              <tr>
                <th>Gender:</th>
                <td>{{ user.gender | ucfirst }}</td>
              </tr>
              <tr>
                <th>MDCN:</th>
                <td>{{ user.folio }}</td>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ user.profile.address }}</td> 
              </tr>
              <tr>
                <th>State</th>
                <td>{{ user.profile.state }}</td>
              </tr>
              <tr>
                <th>ID</th>
                <td>
                  {{ user.chcode }}
                  <button @click="copyTextToClipboard(user.chcode)" class="button is-small is-text">COPY</button>
                </td>
              </tr>
            </table>
          </section>

          <section 
            v-if="isDoctor()"
            slot="p2">
            <Alert 
              v-if="!!!hospitals.length" 
              type="info">
              <span class="ml-i-15 mr-10"><i class="ti ti-info"/></span>
              You have not joined any Hospital. Only joined hospitals will show here.
            </Alert>
            <hgroup v-else>
              <div class="menu-label mb-10">Hospitals</div>
              <p
                v-if="hospitals.length > 0"
                class="">These are the Hospitals you work in.</p>
            </hgroup>
            <div class="row">
              <div class="columns m-0 is-multiline">
                <div
                  v-for="(hospital, index) in hospitals"
                  :key="index"
                  class="column is-half-tablet">
                  <div class="card is-12">
                    <div class="card-content">
                      <div>
                        <b class="osq-text-primary">{{ hospital.name }}</b> 
                      </div>
                      <small class="">{{ hospital.chcode }}</small>

                      <div class="mt-15 has-text-right">
                        <button 
                          class="button is-hovered-danger" 
                          @click="showAlert(hospital)"><i class="ti ti-trash"/></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- For Listing all assigned Patient -->
          <section 
            v-if="isHospital()"
            slot="p2">
<!--             <Alert 
              v-if="!doctorsPatient.length" 
              type="info">
              <span class="ml-i-15 mr-10"><i class="ti ti-info"/></span>
              No Patients Assigned
            </Alert>-->
            <div class="menu-label">Patients assigned to Dr. {{user.first_name}}</div>
          </section>
        </pager>
      </template>
    </ProfileGrid>

    <modal 
      :show="modal"
      size="sm"
      @closed="modal = false">
      <div class="content is-center">
        <h4 class="is-centered">Are you sure you want to leave?</h4>
        <p class="is-italic mb-15">Please understand that all access and privilege to this Hospital will be lost if removed.</p>
        <div class="buttons is-right">
          <button
            class="button" 
            @click="removeHospital">Yes</button>
          <button 
            class="button is-success" 
            @click="modal = false">No</button>
        </div>
      </div>
    </modal>
  </section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import { mapGetters, mapState } from 'vuex'
import ProfileGrid from '@/components/ProfileGrid'
import EditProfile from '@/Mixins/EditProfile.js'

export default {
  name: 'DoctorProfile',
  components: {Modal, ProfileGrid},
  mixins: [EditProfile],
  data() {return {
    modal: false,
    defaults:  {
      avatar: '', 
      first_name: 'Unknown',
      profile: { address: '' },
    },
    currentHospital: '',
  }},
  computed: { 
    user() {
      return this.isDoctor() ? this.getUser : this.findDoctor() || this.defaults
    },
    ...mapGetters(['getUser']),
    ...mapState('doctor', ['hospitals']),
    ...mapState('hospital', ['doctors'])
  },
  activated() {
    if (this.isHospital() && !this.doctors.length) {
      this.$router.push('/doctors')
    }
  },
  methods: {
    // method applies only in hospital interface
    findDoctor() {
      const {_id} = this.$route.params
      return this.doctors.find(e => e.chcode === _id)
    },
		showAlert(a) {
			this.currentHospital = a
			this.modal = true
		},
		removeHospital() {
			this.$parent.manageHospital(this.currentHospital, 'remove')
			this.modal = false
		},
	}
}
</script>
