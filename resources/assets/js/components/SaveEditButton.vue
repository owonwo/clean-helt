<template>
	<button @click="$emit('click')" class="button has-no-motion is-pulled-right is-primary is-small">
		<template v-if="!saved">
			<i class="ti ti-pencil icon"></i> <span>Edit</span>
		</template>
		<template v-else>
			<i class="ti ti-save icon"></i> <span>Save</span>
		</template>
	</button>
</template>

<script>
	export default {
		props: ['saved'],
		data() { return {}},
	}
</script>
