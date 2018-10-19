<template>
	<select v-model="selected" name="selected" class="input">
	    <option disabled="" value="0" selected="">Select State...</option>
	    <option :key="index" v-for="(entry, index) in entries">{{ entry.name }}</option>
	</select>
</template>

<script>
	import LocationAPI from '@/Mixins/LocationAPI';
	
	export default {
		props: ['value'],
		name: "SelectCity",
		mixins: [LocationAPI],
		mounted () {
			this.getStates();
		}
	}
</script>