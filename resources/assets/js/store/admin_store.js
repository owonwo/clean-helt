import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { VuexError } from '@/store/helpers/utilities'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    settings: {
      profile: {
        route: '/api/admin/profile',
        key: 'data'
      },
    },
    models: {
      hospitals: { url: '/api/admin/hospitals' },
      patients: { url: '/api/admin/patients' },
      doctors: { url: '/api/admin/doctors' },
      pharmacies: { url: '/api/admin/pharmacies' },
      labs: { url: '/api/admin/laboratories' },
    },
    counts: {
      hospitals: 0,
      pharmacies: 0,
      doctors: 0,
      labs: 0,
      patients: 0,
    },
  },
  getters: {},
  actions: {
    fetchCounts(context) {
      axios.get('/api/admin/users/counts')
        .then(res => context.commit('set_counts', res.data))
        .catch(VuexError('Error fetching all model counts - Admin'))
    },
    async fetch(context, model) {
      model = context.state.models[model]

      return await ('undefined' === typeof model.url) ?
        Promise.reject() :
        axios.get(model.url)
    },
  },
  mutations: {
    set_counts: (store, payload) => store.counts = payload
  }
})