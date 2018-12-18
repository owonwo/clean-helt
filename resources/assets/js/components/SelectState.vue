<template>
  <div class="select">
    <select 
      v-model="selected" 
      name="selected" 
      @change="$emit('change', $event.target.value)">
      <option 
        disabled="" 
        value="0" 
        selected="">Select State...</option>
      <option 
        v-for="(entry, index) in entries" 
        :key="index">{{ entry.name }}</option>
    </select>
  </div>
</template>

<script>
import LocationAPI from '@/Mixins/LocationAPI'

export default {
	name: 'SelectState',
	mixins: [LocationAPI],
	props: {
		value: {
			type: String,
			required: true,
      default: ""
		}
	},
	mounted () {
		this.getStates()
	}
}
</script>