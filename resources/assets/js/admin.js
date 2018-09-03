import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import routes from './routes/admin_routes.js';

require('./bootstrap'); 

Vue.use(Vuex)
Vue.use(VueRouter)

const router = new VueRouter({
  linkActiveClass: "active",
  routes
});

window.addEventListener('load', () => {
	new Vue({
		el: "#admin",
		data: {
			sidebars: {nav : false, notif: false}
		},
		methods: {
			toggleSidebar() {
				this.sidebars.nav = !this.sidebars.nav;
			},
			toggleNotification() {
				this.sidebars.notif = !this.sidebars.notif;
			}
		},
		router
	});
})
