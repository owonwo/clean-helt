import Router from 'vue-router'
import Settings from '@/patients/Settings.vue'
import Dashboard from '@/patients/Dashboard.vue'
import Profile from '@/patients/Profile.vue'
import ProfileShares from '@/patients/ProfileShares.vue'
import ServiceProviders from '@/patients/ServiceProviders.vue'
import Notifications from '@/components/Notifications.vue'
import NotificationPage from '@/admin/NotificationPage.vue'

const patientRoutes = [
	{
		path: '/dashboard',
		alias: '/',
		components: {
			default: Dashboard,
			logBar: Notifications
		}
	},
	{
		path: '/settings',
		component: Settings
	},
	{
		path: '/services',
		component: ServiceProviders,
	},
	{
		path: '/profile-shares',
		component: ProfileShares,
	},
	{
		path: '/notifications',
		component: NotificationPage
	},
	{
		path: '/profile',
		component: Profile
	},
]

export default new Router({
	mode: 'history',
	base: 'clients/',
	routes: patientRoutes,
	linkActiveClass: 'active'
})
