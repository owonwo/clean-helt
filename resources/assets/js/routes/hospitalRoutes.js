import Router from 'vue-router'
import Dashboard from '@/hospital/Dashboard.vue'
import DoctorsDirectory from '@/hospital/DoctorsDirectory.vue'
import Settings from '@/hospital/Settings.vue'
import Notifications from '@/components/Notifications.vue'
import DoctorProfile from '@/doctors/Profile.vue'
import HospitalProfile from '@/hospital/Profile.vue'
import Patients from '@/doctors/Patients.vue'
import PatientProfile from '@/doctors/PatientProfile.vue'
import PatientRecordsDirectory from '@/doctors/PatientRecordsDirectory.vue'

const routes = [
	{
		alias: '/', path: '/dashboard', 
		name: 'dashboard',
		components: {
			default: Dashboard,
			logBar: Notifications
		}   
	},
	{
		path: '/doctors', 
		name: 'doctors',
		components: {
			default: DoctorsDirectory,
			logBar: Notifications
		}   
	},
	{
		path: '/doctors/:_id', 
		name: 'doctor-profile',
		component: DoctorProfile
	},
	{
		path: '/profile',
		component: HospitalProfile,
	},
	{
		path: '/settings',
		components: {
			default: Settings,
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
]

export default new Router({
	mode: 'history',
	base: 'hospital/',
	routes: routes,
	linkActiveClass: 'active'
})
