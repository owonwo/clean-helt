<template>
	<section class="content">
		<h5 @click="$root.toggleNotification()"><i class="icon mr-15"></i> Notifications</h5>
	</section>
</template>

<script>
	export default {
		name: 'Notifications',
		data() {return {
			show: false,
			notifications: [],
		}}
	}
</script>
