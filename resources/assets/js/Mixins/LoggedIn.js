import _ from 'lodash'
import { mapGetters, mapMutations } from 'vuex'
import { createUserNotification, getNotificationRoute } from '@/store/helpers/notifications.js'
const ServiceProviders = ['hospital', 'doctor', 'pharmacy', 'laboratory']

export default {
  props: ['id'],
  data() {
    return {}
  },
  created() {
    const { id: chcode } = this.$props
    const token = localStorage.getItem('child-token') || localStorage.getItem('api-token')
    const userHasToken = (!!token && 'string' === typeof token)
    const userHasWrongChCode = !this.testChCode(chcode) || _.isEmpty(chcode)

    window.axios.interceptors.response.use(
      (response) => response,
      (error) => {
        const { response: { status, data } } = error
        if (status === 401 && data.message === 'Unauthorized') {
          // this.logout()
        }
        if (status === 422) {
          if (data.errors)
            this.logErrors(data.errors)
        }
        return Promise.reject(error)
      })

    if (userHasWrongChCode)
      console.warn('Logged In User ChCode is invalid!, So features are bound to fail')

    if (userHasToken) {
      window.axios.defaults.headers.common = {
        'Authorization': `Bearer ${token}`,
        'X-Requested-With': 'XMLHttpRequest'
      }
    }
  },
  mounted() {
    try {
      this.$store.commit('set_account_type', this.componentName)
      this.set_config(this.settings)
      this.$store.dispatch('FETCH_USER_DATA')
      this.fetchNotifications()

        !ServiceProviders.includes(this.componentName) ||
        this.$store.dispatch('manage_patient/FETCH_ALL_PATIENTS', this.componentName)
    } catch (x) {
      console.warn('Account Error: invalid profile route.')
    }
  },
  computed: {
    ...mapGetters(['accountType', 'isAdult']),
    ...mapGetters({ user: 'getUser', pendingUsers: 'getPendingUsers' }),
    /**
     * @return String
     */
    componentName() { return this.getComponentName().toLowerCase() }
  },
  methods: {
    ...mapMutations([
      'set_user',
      'set_config',
      'set_notifs',
      'set_pending_patients',
      'remove_from_pending',
      'set_shared_profiles'
    ]),
    //gets the name of the component attached to
    getComponentName() {
      return 'undefined' !== typeof this.$vnode ? this.$vnode.componentOptions.tag : 'UNKNOWN'
    },
    // creates a logout form and submit it.
    logout() {
      if (localStorage.hasOwnProperty('child-token')) {
        localStorage.removeItem('child-token')
        return window.location.assign('/clients/dashboard')
      }
      let input = document.createElement('input')
      let form = $('<form></form>')
      let route = this.getComponentName() === 'ADMIN' ? '/admin/logout' : '/logout'

      input.value = $('meta[name=csrf-token]').attr('content')
      input.name = '_token'
      form.attr('action', route)
        .attr('method', 'POST').append(input)
      $('body').append(form)
      this.clearApiToken()
      form.submit()
    },
    //clears the api tokens created at login time
    clearApiToken() {
      localStorage.removeItem('api-token')
      localStorage.removeItem('refresh-token')
    },
    fetchNotifications() {
      const accountType = this.accountType.toUpperCase(),
        url = getNotificationRoute(accountType)

      console.assert(url, 'The Notification Url is invalid')
      this.$http.get(url.all).then(({ data }) => {
        const notificationList = data.notification.data
          .map(createUserNotification(accountType))
        this.set_notifs(notificationList)
      }).catch(err => console.warn('The Notification Module Failed with error:', err))
    }
  },
}