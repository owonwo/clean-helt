import axios from 'axios'
import { VuexError } from '@/store/helpers/utilities'

const state = {
	entities: {
		hospitals: [],
		pharmacies: [],
		laboratories: []
		// diagnosis_centres: [],
	},
	fetchRequestMade: false,
}

const getters = {
	loading: (store) => !store.fetchRequestMade,
}

const mutations = {
	set_entities: (store, payload) => store.entities = payload,
}

const actions = {
	FETCH(context) {
		return axios.get('/api/entity').then(({data}) => {
			context.state.fetchRequestMade = true
			delete data.data.doctors	
			context.commit('set_entities', data.data)
		}).catch(VuexError('Error Fetching Health Service Entities.'))
	}
}

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}