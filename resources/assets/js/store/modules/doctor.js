import _ from 'lodash'
import axios from 'axios'
import { VuexError, personalify } from '@/store/helpers/utilities'

const state = {
  pendingHospitals: [],
  sentHospitals: [],
  hospitals: [],
  fellow_doctors: []
}

const getters = {

}

const mutations = {
  set_hospitals: (state, payload) => state.hospitals = payload,
  set_fellow_doctors: (state, payload) => state.fellow_doctors = payload,
  set_sent_hospitals: (state, payload) => state.sentHospitals = payload,
  set_pending_hospitals: (state, payload) => state.pendingHospitals = payload,
  set_clients: (state, payload) => state.clients = payload,
}

const actions = {
  async fetchHospitals(context) {
    axios.get('/api/doctor/active-hospitals').then(res => {
      context.commit('set_hospitals', res.data.hospitals)
    })
  },
  manageHospital(context, { hospital, action }) {
    const url = ({
      accept: `/api/doctor/${hospital.chcode}/accept-hospital`,
      decline: `/api/doctor/${hospital.chcode}/decline-hospital`,
      remove: `/api/doctor/${hospital.chcode}/remove-hospital`,
    })[action]

    if (_.isUndefined(url))
      throw Error('Manage Hospital Action is invalid: expected `accept`, `decline` or `remove`')

    axios.patch(url).then(() => {
      context.dispatch('FETCH_ALL_HOSPITAL')
    })
  },
  async fetchSentHospitals(context) {
    axios.get('/api/doctor/sent-hospitals').then((res) => {
      context.commit('set_sent_hospitals', res.data.hospitals)
    })
  },
  FETCH_ALL_HOSPITAL(context) {
    context.dispatch('fetchHospitals')
    context.dispatch('fetchPendingHospitals')
  },
  async fetchPendingHospitals(context) {
    axios.get('/api/doctor/pending-hospitals').then((res) => {
      context.commit('set_pending_hospitals', res.data.hospitals)
    })
  },
  FETCH_FELLOW_DOCTORS(context, payload) {
    axios.get(`/api/doctor/doctors-eligible/${payload.share_id}`).then(({ data }) => {
      context.commit('set_fellow_doctors', data.doctors.map(personalify))
    }).catch(VuexError('Error Fetching Fellow Doctors'))
  },
  async REFER_TO_DOCTOR(context, { share_id, doctor_chcode }) {
    try {
      if (doctor_chcode == '') throw Error('Doctor Refer ChCode is invalid')
      const { data } = await axios.post(`/api/doctor/patients/${share_id}/refer/${doctor_chcode}`)
      return data.message
    } catch (x) {
      VuexError('Error Refering Patient to Doctor')()
      throw Error(x)
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}