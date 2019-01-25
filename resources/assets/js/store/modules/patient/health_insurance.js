import axios from 'axios'
import { VuexError, urlGenerator, guessDataKey, extractRecords } from '@/store/helpers/utilities'

const health = urlGenerator('health_insurance')

const state = {
  insurances: [],
}

const mutations = {
  set_insurances: (store, payload) => store.insurances = payload,
}

const actions = {
  FETCH(context) {
    return axios.get(health(context).base()).then(guessDataKey).then(({ data }) => {
      context.commit('set_insurances', extractRecords(data))
    }).catch(VuexError('Error Fetching Insurances.'))
  },
  async CREATE(context, payload) {
    try {
      const data = await axios.post(health(context).base(), payload)
      context.dispatch('FETCH')
      return data
    } catch (x) {
      VuexError('Error Fetching Insurances.')()
      throw Error(x)
    }
  },
  DELETE(context, id) {
    return axios.delete(health(context).delete(id))
      .then(() => {
        const changes = context.state.insurances.filter(e => id !== e.id)
        context.commit('set_insurances', changes)
      })
      .catch(VuexError(`Error deleting insurance with id: ${id}`))
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}