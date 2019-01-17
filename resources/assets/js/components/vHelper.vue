<template>
  <span>
	    <span 
	      v-if="!err.required" 
	      class="help has-text-danger">Field is required</span>
	    <span 
	      v-else-if="isProp('minLength')" 
	      class="help has-text-danger">
	      	Field must have at least {{ err.$params.minLength.min }} letters.
	      </span>
	    <span 
	      v-else-if="isProp('email')" 
	      class="help has-text-danger">Invalid email provided</span>
  </span>
</template>

<script>
	export default {
		props: ['err'],
		methods: {
			isProp(key) {
				return Object.keys(this.err.$params).includes(key) && !this.err[key]
			}
		}
	}
</script>