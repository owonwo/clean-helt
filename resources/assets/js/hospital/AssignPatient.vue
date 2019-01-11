<template>
  <div class="">
    <h5 class="title is-6">
      <i class="ti ti-share icon"/> Assign Patient
    </h5>
    <div>
      <label class="menu-label">Select Doctors</label>
      <multiselect 
        v-model="value"
        :options="options" 
        :multiple="true" 
        :close-on-select="false" 
        :clear-on-select="false" 
        :preserve-search="true" 
        :preselect-first="false" 
        placeholder="Pick some doctors" 
        label="name"
        track-by="name"/>
        <!-- <label class="menu-label">Selected Doctors</label>
          <ul class="tags">
            <li 
              v-for="(doctor, index) in value" 
              :key="index"
              class="tag is-primary">
              {{ doctor.name }}
            </li>
          </ul> -->
    </div>
    <div 
      v-if="sharedProfiles.length <= 0" 
      class="notification is-info">No Available Client.</div>
    <template v-else>
      <label class="menu-label">Select Patients</label>
      <div 
        class="field">
        <select 
          v-model="share_id" 
          class="input">
          <option 
            value="0" 
            disabled=""
            selected="">Select Patient...</option>
          <option 
            v-for="(profile) in sharedProfiles" 
            :value="profile.id" 
            :key="profile.id">
            {{ profile.patient.chcode }} - {{ profile.patient.name }}
          </option>
        </select>
      </div>
    </template>

    <div class="field mt-50">
      <button
        v-if="value.length > 0"
        class="button is-fullwidth is-primary is-block is-outlined"
        @click="shareToDoctor()">
        Assign
      </button>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import { mapState } from 'vuex'
import Multiselect from 'vue-multiselect'

export default {
	name: 'AssignPatient',
	components: { Multiselect },
	props: ['doctor', 'patientShareId'],
	data: () => ({
    value: [],
		share_id: 0,
    isLoading: false,
	}),
	computed: {
		...mapState('hospital', ['doctors']) ,
		...mapState('manage_patient', {
			sharedProfiles: 'patients'
		}),
    options() {
      return this.doctors.map(this.restructure)
    }
	},
	watch: {
		doctor(chcode) {
			this.addDoctorToOptions(chcode)
		},
		patientShareId(id) {
			this.addPatientById(id)
		}
	},
	mounted() {
		if (!this.doctors.length)
			this.$store.dispatch('hospital/FETCH_DOCTORS')
	},
	methods: {
		restructure({first_name, last_name, chcode }) {
      return { name: ['Dr', first_name, last_name].join(' '), chcode }
		},
		addPatientById(id) {
			if (id) this.share_id = id
		},
		addDoctorToOptions(chcode = '') {
			if(chcode) {
				const doctor = this.restructure(_.find(this.doctors, e => e.chcode === chcode))
				this.value = []
				this.value.push(doctor)
			}
		},
		shareToDoctor() {
			const {share_id} = this
			const doctor_ids = this.value.map(e => e.chcode)
			this.isLoading = true

			this.$store.dispatch('hospital/SHARE_TO_DOCTOR', {share_id, doctor_ids})
			.then(() => this.$store.dispatch('hospital/FETCH_DOCTORS'))
			.then(() => this.success_message('Profile share successful'))
			.then(() => (this.isLoading = false))
			.then(() => this.$emit('success'))
			.catch((err) => {
				console.error(err)
				this.error_message('Assignment failed!')
			})
		}
	}
}
</script>