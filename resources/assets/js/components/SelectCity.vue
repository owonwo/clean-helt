<template>
	<select v-model="selected" name="selected" class="input">
	    <option disabled="" value="0" selected="">Select City...</option>
	    <option :key="index" v-for="(entry, index) in entries">{{ entry }}</option>
	</select>
</template>

<script>
	import LocationAPI from '@/Mixins/LocationAPI';
	
	export default {
		name: "SelectCity",
		mixins: [LocationAPI],
		props: ['value', 'state'],
		watch: {
			state (a, b) {
				this.getLgas(a);
			},
		}
	}
</script>