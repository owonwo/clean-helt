import Router from 'vue-router'
import Profile from '@/doctors/Profile.vue'
import Patients from '@/doctors/Patients.vue'
import Dashboard from '@/doctors/Dashboard.vue'
import PatientProfile from '@/doctors/PatientProfile.vue'
import PatientRecordsDirectory from '@/doctors/PatientRecordsDirectory.vue'
import Notifications from '@/components/Notifications.vue'

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
	}
];

export default new Router({
	mode: "history",
	base: "doctors/",
	routes,
	linkActiveClass: 'active'
})
