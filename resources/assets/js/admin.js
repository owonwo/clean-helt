import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import VueMoment from 'vue-moment'
import Notification from 'vue-notification'

Vue.use(VueMoment)
Vue.use(Notification)

import Admin from '@/Admin.vue'
import routes from './routes'
import token from './token'

require('./bootstrap');
require('@/directives');
require('@/Mixins/global');

Vue.use(Vuex)
Vue.use(VueRouter)

window.addEventListener('load', () => {
	new Vue({
		el: "#admin",
		components: {Admin},
		router: routes.admin,
		mounted() {
			window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
		},
		data: {
		    user: {},
			sidebars: {nav : false, notif: true}
		},
		methods: {
			toggleSidebar() {
			  this.sidebars.nav = !this.sidebars.nav;
			},
			toggleNotification() {
			  this.sidebars.notif = !this.sidebars.notif;
			},
			getIcon(name) {
			  return ['osf osf-'].concat(name.toLowerCase()).join("");
			}
		},
	});
})
