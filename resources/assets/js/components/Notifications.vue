<template>
  <aside class="content">
    <h5 
      class="notif-heading" 
      @click.stop="$root.toggleNotification()">
      <i 
        :class="{'is-dotted': unread.length > 0}"
        class="icon osf osf-notification hoverable mr-20"/> 
      <span>Notifications</span>
    </h5>
    <v-scrollbar class="notifications">
      <div 
        v-if="!notifs.length" 
        class="has-text-centered is-italic">There are no Notifications</b></div>
      <notification 
        v-for="(notif, index) in [...unread,...read]" 
        :key="index" 
        :type="notif.read ? '' : 'info'"
        @click="markAsRead(notif)">
        <template slot="time">{{ notif.created_at | moment('from', 'now') }}</template>
        {{ notif.data.data }}
      </notification>
    </v-scrollbar>
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
import {mapGetters} from 'vuex'
import NotificationCard from '@/components/NotificationCard.vue'

export default {
	name: 'Notifications',
	components: {notification: NotificationCard},
	data() {return {
		show: false,
		notifications: [],
	}},
	computed: {
		read() {
			return this.notifs.filter(e => e.read)
		},
		unread() {
			return this.notifs.filter(e => !e.read)
		},
		...mapGetters(['notifs'])
	},
	methods: {
		markAsRead(notif) {
			notif.isRead().then((res) => {
				notif.read = true
			}).catch(err => {
				console.trace(err, 'Notification Error!')
			})
		}
	}
}
</script>
