import Vue from 'vue'
import axios from 'axios'
import Router from 'vue-router'
import VueMoment from 'vue-moment'
import Notification from 'vue-notification'

// #pages
import Doctor from '@/Doctor.vue'
import Patient from '@/Patient.vue'
import Hospital from '@/Hospital.vue'
import Pharmacy from '@/Pharmacy.vue'
import Laboratory from '@/Laboratory.vue'
import Login from '@/Login.vue'
import Register from '@/Register.vue'

Vue.use(Router) 
Vue.use(VueMoment)
Vue.use(Notification)
Vue.prototype.$http = axios

import store from '@/store/'

require('@/directives')
require('@/Mixins/global')

new Vue({
	el: '#app',
	store,
	components: {Doctor, Hospital, Patient, Pharmacy, Laboratory, Login, Register},
	data: {
		user: {},
		sidebars: {nav : false, notif: true}
	},
	methods: {
		toggleSidebar() {
			this.sidebars.nav = !this.sidebars.nav
		},
		toggleNotification() {
			this.sidebars.notif = !this.sidebars.notif
		},
		getIcon(name) {
			return ['osf osf-'].concat(name.toLowerCase()).join('')
		}
	},
})
