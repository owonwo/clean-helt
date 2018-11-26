<template>
  <section>
    <table class="table is-fullwidth is-narrow">
      <tr>
        <th width="10">S/N</th>
        <th>Illness</th>
        <th>Date of Onset</th>
      </tr>
      <tr 
        v-for="(entry, index) in histories"
        :key="index">
        <td v-text="index + 1"/>
        <td v-text="entry.illness"/>
        <td v-text="entry.date_of_onset"/>
      </tr>
    </table>
  </section>
</template>

<script>
import { mapState } from 'vuex'

export default {
	name: 'MedicalHistory',
	data() {
		return {
			index: false,
		}
	},
	computed: {
		...mapState('medicalHistory', {
			histories: (store) => store.histories 
		})
	},
	mounted() {
		this.$store.dispatch('medicalHistory/FETCH_MEDICAL_HISTORY')
	},
}
</script>