const routes = [
	{ 
		alias: '/', path: '/dashboard', name: "dashboard",
		components: {
			default: require('../admin/Dashboard.vue'),
			logBar: require('../admin/Notifications.vue')
		} 
	},
	{ 
		path: '/users', name: "users", 
		component: require('../admin/Users.vue'),

	},
];

export default routes;
