<template>
  <form @submit.prevent="referToDoctor">
    <h1 class="title is-4">Refer another Doctor.</h1>
    <p class="mb-10">Pick a doctor to refer this patient to.</p>
    <div class="field">
      <div class="select is-fullwidth">
        <select v-if="fellow_doctors.length" v-model="doctor">
          <option value="#">Pick a Doctor...</option>
          <option 
            v-for="doctor in fellow_doctors" 
            :key="doctor.id"
            :value="doctor.chcode">{{ doctor.fullname }}
          </option>
        </select>
        <p v-else>No Doctor available.</p>
      </div>
    </div>
    <button 
      v-show="testChCode(doctor)"
      class="button is-primary">Submit</button>
  </form>
</template>

<script>
import { mapState } from 'vuex'

export default {
	data() {return {
      doctor: 0,
	}},
	/* eslint-disable-next-line */
	props: ['shareId'],
	computed: {
		...mapState('doctor', ['fellow_doctors'])
	},
	watch: {
		shareId(a) {
			this.$store.dispatch('doctor/FETCH_FELLOW_DOCTORS', {share_id: a})
		}
	},
  methods: {
    referToDoctor() {
      this.$store.dispatch('doctor/REFER_TO_DOCTOR', { 
        doctor_chcode: this.doctor, 
        share_id: this.$props.shareId, 
      }).then((message) => this.success_message(message))
        .catch(error => this.error_message(error.message))
    }
  }
}
</script>