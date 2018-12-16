<template>
  <section>
    <section class="columns">
      <div class="column is-half">
        <h5 class="osq-group-subtitle-alt mb-15">Patient Profile</h5>
        <ProfileBox 
          v-show="profile" 
          :avatar-src="patient.avatar"
          class="is-fullwidth is-green">
          <h3 class="profile-title">{{ patient.name }}</h3>
          <p>{{ patient.gender | ucfirst }}</p>
          <div class="mt-30">
            <button 
              class="button is-outlined is-rounded is-dark" 
              @click="showProfile = true">Bio-Data</button>
            <router-link 
              v-if="accountType === 'doctor'"
              :to="{name:'add-record', params: {chcode: patient.chcode, patient_id: patient.id }}" 
              class="button ml-10 is-outlined is-rounded is-dark">
              Add Record
            </router-link>
          </div>
        </ProfileBox>
        <section class="px-0">
          <accordion>
            <template slot="heading">Emergency Hospital</template>
            <section slot="content">
              <h3 class="m-0">{{ patient.emergency_hospital_name | ucfirst }}</h3>
              <b class="m-0">Address:</b>
              <p>{{ patient.emergency_hospital_address | ucfirst }}</p>
            </section>
          </accordion>
          <accordion class="menu">
            <template slot="heading">Next of Kin<!-- Emergency Contact --></template>
            <section 
              slot="content" 
              class="content">
              <h1 class="title is-5 mb-0">{{ patient.nok_name }}</h1>
              <div>
                <small>Email Address: {{ patient.nok_email }}</small>
              </div>
              <div>
                <small>Phone Number: {{ patient.nok_phone }}</small>
              </div>
            </section>
          </accordion>
        </section>
        <hr>
        
      </div>

      <div class="column is-half">
      	<h1 class="osq-group-subtitle-alt mb-10">Medical Records</h1>
        <div class="columns">
          <div class="column">
            <router-link 	
              to="/" 
              tag="div" 
              class="card pointed osq-text-primary card-content">
              Allergies
          	</router-link>
          </div>
        </div>
        <!-- <h1 class="osq-group-subtitle-alt mb-10"><i class="osf osf-note osf-14px"/> NOTES</h1>
        <v-scrollbar 
          v-once 
          :settings="settings" 
          style="height:100vh">
          <DoctorNote :key="a" class="mb-10"/>
        </v-scrollbar> -->
      </div>
    </section>

    <modal 
      :show="showProfile" 
      :show-header="true" 
      class="is-note" 
      @closed="showProfile = false">
      <template slot="modal-title"><b>Bio-Data</b>: {{ patient.name }}</template>
      <table class="table is-borderless is-fullwidth">
        <tr>
          <td width="150">Full Name</td>
          <td>{{ patient.fullname }}</td>
        </tr>
        <tr>
          <td>Phone Number</td>
          <td>{{ patient.phone }}</td>
        </tr>
        <tr>
          <td>Age</td>
          <td>{{ patient.dob | moment("from") }}</td>
        </tr>
        <tr>
          <td>Gender</td>
          <td>{{ patient.gender | ucfirst }}</td>
        </tr>
        <tr>
          <td>Address</td>
          <td>{{ patient.address }}</td>
        </tr>
        <tr>
          <td>City</td>
          <td>{{ patient.city }}</td>
        </tr>
        <tr>
          <td>State</td>
          <td>{{ patient.state }}</td>
        </tr>
        <tr>
          <td>Country</td>
          <td>{{ patient.country }}</td>
        </tr>
      </table>
    </modal>
  </section>
</template>

<script>
	import Modal from '@/components/Modal.vue'
	import DoctorNote from '@/components/DoctorNote.vue'
	import { mapGetters, mapState } from 'vuex'

	export default {
		name: 'PatientProfile',
		components: {DoctorNote, Modal},
		data() {return {
			settings: { maxScrollbarLength: 60 },
			showProfile: false,
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
