import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMoment from 'vue-moment'
import Notification from 'vue-notification'
import { mapState } from 'vuex'

Vue.use(VueMoment)
Vue.use(VueRouter)
Vue.use(Notification)

require('./bootstrap')
require('@/directives')
require('@/Mixins/global')

import store from '@/store/admin_store'
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'
import DashboardActions from '@/Mixins/DashboardActions'

Vue.prototype.$http = window.axios

window.addEventListener('load', () => {
  new Vue({
    store,
    el: '#admin',
    router: routes.admin,
    mixins: [LoggedIn, DashboardActions],
    data: {
      settings: {
        profile: {
          route: '/api/admin/profile',
          key: 'data'
        },
      },
    },
    computed: {
      ...mapState(['counts'])
    },
    mounted() {
      this.$store.dispatch('fetchCounts')
    },
  })
})