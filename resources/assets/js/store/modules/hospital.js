import axios from 'axios'
import _ from 'lodash'

const state = {
  doctors: [],
  pendingDoctors: [],
  sentDoctors: [],
  isLoaded: false
}

const mutations = {
  set_doctors: (state, payload) => state.doctors = payload,
  set_pending_doctors: (state, payload) => state.pendingDoctors = payload,
  set_sent_doctors: (state, payload) => state.sentDoctors = payload,
}

const getters = {
  combined: (store) => {
    let { doctors , pendingDoctors } = store
    const buildStatus = doctors => state => {
        return doctors.map(e => _.extend(e, { status: state }))
    }
    return _.uniqBy([
        ...buildStatus(pendingDoctors)(false),
        ...buildStatus(doctors)(true)
    ], 'id')
  },
  sortByStatus: (store,getters) => getters.combined.sort(e => e.status == true)
}

const actions = {
    // gets all the doctors hospital sent request
    async FETCH_SENT_DOCTORS(context) {
      try {
        const {data} = await axios.get('/api/hospital/doctors/sent')
        console.assert(!!data.doctors, 'Failed loading Doctors')
        context.commit('set_doctors', data.doctors)
      } catch (x) {
        throw Error(x)
      }
    },
    // gets all the hospital doctors
    async FETCH_DOCTORS(context) {
      try {
        const {data} = await axios.get('/api/hospital/doctors')
        console.assert(!!data.doctors, 'Failed loading Doctors')
        context.commit('set_doctors', data.doctors)
      } catch (x) {
        throw Error(x)
      }
    },

    //gets all pending doctors
    async FETCH_PENDING_DOCTORS(context) {
      try {
        const {data} = await axios.get('/api/hospital/doctors/pending')
        console.assert(!!data.doctors, 'Failed loading Pending Doctors')
        context.commit('set_pending_doctors', data.doctors)
      } catch (x) {
        throw Error(x)
      }
    },
    async ACCEPT_DOCTOR(context, doctor) {
      try {
        if (_.isUndefined(doctor.chcode)) throw Error('Can not accept a Doctor without Chcode.')
        const { data } = await axios.patch(`/api/hospital/doctors/${doctor.chcode}/accept`)
        context.dispatch('FETCH_DOCTORS')
        context.dispatch('FETCH_PENDING_DOCTORS')
        return data
      } catch (x) { throw Error(x) }
    },
    async shareToDoctor(context, payload) {
      try {
        let {share_id, doctor_id} = payload
        const { data } = await axios.patch(`/api/hospital/patients/${share_id}/assign/${doctor_id}`)
        context.dispatch('FETCH_DOCTORS')
        return data
      } catch (x) {
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