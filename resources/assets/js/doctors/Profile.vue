<template>
  <section>
    <div class="content-top-bar">
      <h3>Doctors Profile</h3>
    </div>
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
              <template v-if="!!user.profile">
                <tr>
                  <th>Address</th>
                  <td>{{ user.profile.address }}</td> 
                </tr>
                <tr>
                  <th>State</th>
                  <td>{{ user.profile.state }}</td>
                </tr>
              </template>
              <tr>
                <th>ID</th>
                <td>
                  {{ user.chcode }}
                  <button 
                    class="button is-small is-text" 
                    @click="copyTextToClipboard(user.chcode)">COPY</button>
                </td>
              </tr>
            </table>
          </section>

          <section slot="p2">
            <template v-if="isDoctor()">
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
            </template>

            <!-- For Listing all assigned Patient -->
            <template v-if="isHospital()">
              <div class="menu-label">Patients assigned to Dr. {{ user.first_name }}</div>
              <Alert 
                v-if="!doctorPatients.length" 
                type="info">
                <span class="ml-i-15 mr-10"><i class="ti ti-info"/></span>
                No Patients Assigned
              </Alert>
              <PatientList 
                v-for="(profile_share) in doctorPatients"
                :profile="profile_share"
                :key="profile_share.id"
                :assigned="false"/>
            </template>
          </section>
        </pager>
      </template>
    </ProfileGrid>

    <modal 
      v-if="isDoctor()"
      ref="modal"
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
            @click="$refs.modal.hide()">No</button>
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
import PatientList from '@/doctors/PatientList'

export default {
  name: 'DoctorProfile',
  components: {Modal, ProfileGrid, PatientList},
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
    doctorPatients() {
      return (this.user.assigned_shares || []).map(e => e.profile_share)
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
      const {currentHospital: hospital} = this
      this.$store.dispatch('doctor/manageHospital', { hospital, action: 'remove'})
      this.$refs.modal.hide()
    },
  }
}
</script>
