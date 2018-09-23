import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import VueMoment from 'vue-moment'
import Notification from 'vue-notification'

Vue.use(VueMoment)
Vue.use(Notification)

import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'

require('./bootstrap');
require('@/directives');
require('@/Mixins/global');

Vue.use(Vuex)
Vue.use(VueRouter)

window.addEventListener('load', () => {
	new Vue({
		el: "#admin",
		router: routes.admin,
		mixins: [LoggedIn],
		mounted() {
			this.fetchCounts();
		},
		watch: { models() { this.fetchCounts() }},
		data: {
			settings: {
				profile: {
					route: `/api/admin/profile`,
					key: 'data'
				},
			},
		    counts: {
				pharmacies: 0, hospitals: 0,
		    	doctors: 0, labs: 0, patients: 0,
		    },
			sidebars: {nav : false, notif: true},
			models: {
				patients: { url : '/api/admin/patients'},
				doctors: { url : '/api/admin/doctors'},
				hospitals: { url : '/api/admin/hospitals'},
				pharmacies: { url : '/api/admin/pharmacies'},
				labs: { url : '/api/admin/laboratories'},
			},
		},
		methods: {
			toggleSidebar() {
			  this.sidebars.nav = !this.sidebars.nav;
			},
			fetchCounts() { 
				this.$http.get('/api/admin/users/counts').then(res => this.counts = res.data);
			},
			toggleNotification() {
			  this.sidebars.notif = !this.sidebars.notif;
			},
			async fetch(model) {
				model = this.getModel(model);
				return await 'undefined' === typeof model.url ? Promise.reject() :  this.$http.get(model.url)
			},
			getModel(model) {
				return this.models[model] || {};
			},
			getIcon(name) {
			  return ['osf osf-'].concat(name.toLowerCase()).join("");
			}
		},
	});
})
