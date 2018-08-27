import Router from 'vue-router'
import Dashboard from '@/admin/Dashboard.vue'
import NotificationPage from '@/admin/NotificationPage.vue'
import Notifications from '@/components/Notifications.vue'
import Users from '@/admin/Users.vue'

const adminRoutes = [
  {
    alias: '/', path: '/dashboard', 
    name: "dashboard",
    components: {
      default: Dashboard,
      logBar: Notifications
    }   
  },
  {
    path: '/users', name: 'users',
    component: Users,
  }, 
  {
    path: '/notifications', name: 'notificaiton',
    component: NotificationPage,
  }
];

export default new Router({
  mode: "history",
  base: "admin/",
  routes: adminRoutes,
  linkActiveClass: "active",
})
