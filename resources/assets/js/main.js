import Vue from 'vue'
import axios from 'axios'
import Router from 'vue-router'
import Vuelidate from 'vuelidate'
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

import WgDialog from '@/plugins/WgDialog'

Vue.use(Router)
Vue.use(WgDialog)
Vue.use(VueMoment)
Vue.use(Vuelidate)
Vue.use(Notification)
Vue.prototype.$http = axios

import store from '@/store/'

require('@/directives')
require('@/Mixins/global')

window.trace = (message) => (x) => {
  console.log(x, message)
  return x
}

new Vue({
  el: '#app',
  store,
  components: { Doctor, Hospital, Patient, Pharmacy, Laboratory, Login, Register },
  data: {
    user: {},
  },
  methods: {
    getIcon(name) {
      return ['osf osf-'].concat(name.toLowerCase()).join('')
    }
  },
})