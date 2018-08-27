<template>
	<aside class="content">
		<h5 @click.stop="$root.toggleNotification()"><i class="icon osf osf-bell-gray hoverable mr-20"></i> Notifications</h5>
		<section class="notifications">
			<notification type="info">
				A new patient was admitted by UPTH
			</notification>
			<notification type="danger">
				Password reset was not successful, due to the updates on the 
				server.
			</notification>
			<notification type="warning">
				You have a query from the Admin for abusing a patient and 
				add false information to he's record.
			</notification>
		</section>
	</aside>
</template>
<style lang="scss">
	.notification {
		margin-bottom: .5rem !important;
		transform: translateX(0);
		border-radius: .5rem;
		transition: all .3s cubic-bezier(0.1, 0.29, 0.34, 0.99) .3s;
		padding: {top: 5px; bottom: 5px}

		#osq-logs.collapse & {
			transform: translateX(50px);
		}
	}
</style>
<script>
	import NotificationCard from '@/components/NotificationCard.vue';

	export default {
		name: 'Notifications',
		components: {notification: NotificationCard},
		data() {return {
			show: false,
			notifications: [],
		}}
	}
</script>
