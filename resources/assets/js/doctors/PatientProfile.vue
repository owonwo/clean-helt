<template>
  <section>
    <ProfileGrid 
      :name="patient.name"
      :avatar="patient.avatar"
      avatar-url="">
      <template slot="navigation">
        <li><a href="#basic">Basic Information</a></li>
        <li><a href="#allergy">Allergies</a></li>
      </template>
      <pager 
        slot-scope="pager" 
        :current="pager.page">
        <section slot="p1">
          <div class="menu-label">User Information</div>
          <accordion :show="true">
            <template slot="heading">Basic</template>
            <section slot="content">
              <table class="table is-narrow">
                <tr class="">
                  <th width="150">First Name</th>
                  <td>
                    <span>{{ patient.first_name }}</span>
                  </td>
                </tr>
                <tr class="">
                  <th>Last Name</th>
                  <td>
                    <span>{{ patient.last_name }}</span>
                  </td>
                </tr>
                <tr class="">
                  <th>Other Name</th>
                  <td>
                    <span>{{ patient.middle_name }}</span>
                  </td>
                </tr>
                <tr class="">
                  <th>Date of Birth</th>
                  <td>
                    <span>{{ [ patient.dob, "YYYY-MM-DD" ] | moment("Do MMMM, YYYY") }}</span>
                  </td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>
                    <span>{{ patient.email }}</span>
                  </td>
                </tr>
                <tr>
                  <th>Gender</th>
                  <td>{{ patient.gender | ucfirst }}</td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td>
                    <span>{{ patient.address }}</span>
                  </td>
                </tr>
                <tr>
                  <th>City</th>
                  <td>
                    <span>{{ patient.city }}</span>
                  </td>
                </tr>
                <tr>
                  <th>State:</th>
                  <td>
                    <span>{{ patient.state }}</span>
                  </td>
                </tr>
                <tr>
                  <th>Marital Status:</th>
                  <td>
                    <span>{{ patient.marital_status | ucfirst }}</span>
                  </td>
                </tr>
                <tr>
                  <th>Phone Number:</th>
                  <td>
                    <span>{{ patient.phone }}</span>
                  </td>
                </tr>
              </table>
            </section>
          </accordion>
          <!-- Next of Kin -->
          <accordion class="menu">
            <template slot="heading">Next of Kin</template>
            <section 
              slot="content" 
              class="content">
              <h1 class="title is-5 mb-10">{{ patient.nok_name }}</h1>
              <div>
                <p>Email Address: <b>{{ patient.nok_email }}</b></p>
              </div>
              <div>
                <p>Phone Number: <b>{{ patient.nok_phone }}</b></p>
              </div>
            </section>
          </accordion>
          <!-- Emergency Contact -->
          <accordion :show="false">
            <template slot="heading">Emergency Hospital</template>
            <section slot="content">
              <div>
                <span>No Emergency Address Yet</span>
                <template>
                  <h3 class="mb-5">{{ patient.emergency_hospital_name }}</h3>
                  <p style="opacity: 0.8">{{ patient.emergency_hospital_address }}</p>
                </template>
              </div>
                </div>
            </section>
          </accordion>
        </section>
        <div slot="p2">
          <div class="level">
            <div class="menu-label">
              <span>ALLERGIES</span>
            </div>
            <!-- @click="editModal('allergy', {})" -->
            <HoverRevealButton>
              <span 
                slot="icon" 
                class="ti ti-plus"/>
              <span slot="text">Add</span>
            </HoverRevealButton>
          </div>
          <alert 
            v-if="!records.allergy.length" 
            type="info">
            You have a clean Allergy record.
          </alert>
          <table 
            v-else 
            class="table is-small is-fullwidth" 
            style="font-size:small">
            <tr>
              <th width="50">S/N</th>
              <th>Allergy</th>
              <th>Reaction</th>
              <th width="170">Date of Occurence</th>
              <th/>
            </tr>
            <tr 
              v-for="(entry, index) in records.allergy" 
              :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ entry.allergy }}</td>
              <td>{{ entry.reaction }}</td>
              <td>{{ entry.last_occurance }}</td>
            </tr>
          </table>
        </div>
      </pager>
    </ProfileGrid>
  </section>
</template>

<script>
  import ProfileGrid from '@/components/ProfileGrid.vue'
  import { mapGetters, mapState } from 'vuex'

  export default {
    name: 'PatientProfile',
    components: { ProfileGrid },
    data() {return {
      page: 0,
      settings: { maxScrollbarLength: 60 },
      showProfile: false,
      records: {
        allergy: [],
      },
      profile: {}
    }},
    computed: {
      ...mapGetters(['accountType']),
      ...mapState('manage_patient', {patient: 'currentPatient'}),
      ...mapState('manage_patient', ['patients'])
    },
    mounted () {
      const { patient_id } = this.$route.params
      if (this.patients.length < 1) this.$router.back()
      this.$store.commit('manage_patient/set_current_patient', patient_id)
      this.$store.dispatch('manage_patient/FETCH_PATIENT_DATA')
    },
    methods: {
      recordsRoute(type = 'all') {
        const params = Object.assign(this.$route.params, {
          chcode: this.patient.chcode,
        })
        const query = {type}
        return {
          name: 'patient-records', 
          params,
          query
        }
      },
      getProfile() {
        let profile = this.$store.getters.getProfileByPatientId(this.getId())
        if('undefined' == typeof profile) 
          return  _.debounce(this.getProfile.bind(this), 2000)()
        this.profile = profile
        this.patient = _.extend({}, this.profile.patient)
      },
      getId() {
        const patient_id = parseInt(this.$route.params.patient_id)
        _.isNumber(patient_id) || this.$router.replace({name: 'patients'})
        return patient_id
      }
    }
  }
</script>
