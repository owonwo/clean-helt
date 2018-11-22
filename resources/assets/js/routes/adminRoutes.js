import Router from 'vue-router'
import Dashboard from '@/admin/Dashboard.vue'
import NotificationPage from '@/admin/NotificationPage.vue'
import CreateServiceProvider from '@/admin/CreateServiceProvider.vue'
import Notifications from '@/components/Notifications.vue'
import Users from '@/admin/Users.vue'

const adminRoutes = [
	{
		alias: '/', path: '/dashboard', 
		name: 'dashboard',
		meta: {
			title: 'Admin | Dashboard'
		},
		components: {
			default: Dashboard,
			logBar: Notifications
		}   
	},
	{
		path: '/users', name: 'users',
		meta: {
			title: 'Manage Clients | CleanHelt Admin'
		},
		component: Users,
	}, 
	{
		path: '/create-provider', 
		name: 'create_provider',
		meta: {
			title: 'Add Service Provider | CleanHelt Admin',
		},
		component: CreateServiceProvider,
	}, 
	{
		path: '/notifications', name: 'notificaiton',
		meta: {
			title: 'Notifications | CleanHelt Admin',
		},
		component: NotificationPage,
	}
]

const $router = new Router({
	mode: 'history',
	base: 'admin/',
	routes: adminRoutes,
	linkActiveClass: 'active',
})

// This callback runs before every route change, including on page load.
$router.beforeEach((to, from, next) => {
	// This goes through the matched routes from last to first, finding the closest route with a title.
	// eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
	const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title)

	// Find the nearest route element with meta tags.
	const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags)
	const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags)

	// If a route with a title was found, set the document (page) title to that value.
	if(nearestWithTitle) document.title = nearestWithTitle.meta.title

	// Remove any stale meta tags from the document using the key attribute we set below.
	Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el))

	// Skip rendering meta tags if there are none.
	if(!nearestWithMeta) return next()

	// Turn the meta tag definitions into actual elements in the head.
	nearestWithMeta.meta.metaTags.map(tagDef => {
		const tag = document.createElement('meta')

		Object.keys(tagDef).forEach(key => {
			tag.setAttribute(key, tagDef[key])
		})

		// We use this to track which meta tags we create, so we don't interfere with other ones.
		tag.setAttribute('data-vue-router-controlled', '')

		return tag
	})
	// Add the meta tags to the document head.
		.forEach(tag => document.head.appendChild(tag))

	next()
})

export default $router
