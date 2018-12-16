<template>
	<section>
		<div 
	      v-for="(entry) in hospitalizations" 
	      :key="entry.id" 
	      class="mb-20">
	      <h1 class="title mb-5 is-5">{{ entry.hospitalization_type }}</h1>
	      <p>Doctor: {{ entry.doctor }}</p>
	      <p>Hospital: {{ entry.hospital }}</p>
	      <p>Reason: {{ entry.reason }}</p>
	      <p>Complications: {{ entry.complications }}</p>
	    </div>
	</section>
</template>

<script>
import { mapState } from 'vuex'

export default {
	name: 'Hospitalizations',
	computed: {
		...mapState('medicalHistory', ['hospitalizations'])
	},
	mounted() {
		this.$store.dispatch('medicalHistory/FETCH_HOSPITALIZATIONS')
	}
}
</script>