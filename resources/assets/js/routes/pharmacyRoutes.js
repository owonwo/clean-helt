import Router from 'vue-router'
import Profile from '@/pharmacy/Profile.vue'
import Patients from '@/doctors/Patients.vue' 
import Dashboard from '@/pharmacy/Dashboard.vue'
import PatientProfile from '@/doctors/PatientProfile.vue'
import Notifications from '@/components/Notifications.vue'
import PatientRecordsDirectory from '@/doctors/PatientRecordsDirectory.vue'

const routes = [
	{
		path: '/dashboard',
		alias: '/',
		components: {
			default: Dashboard,
			logBar: Notifications
		}
	},
	{
		path: '/patients',
		components: {
			default: Patients,
			logBar: Notifications
		}
	},
	{
		path: '/profile',
		components: {
			default: Profile,
			logBar: Notifications
		}
	},
	{
		path: '/patients/:patient_id',
		name: 'patient-profile',
		components: {
			default: PatientProfile,
			logBar: Notifications
		}
	},
	{
		path: '/patients/:patient_id/records',
		name: 'patient-records',
		components: {
			default: PatientRecordsDirectory,
			logBar: Notifications
		}
	},
];

export default new Router({
	mode: "history",
	base: "pharmacy/",
	routes,
	linkActiveClass: 'active'
})
