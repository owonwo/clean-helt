import axios from 'axios'
import { compose } from 'lodash/fp'
import { VuexError, buildLab, trace } from '@/store/helpers/utilities'

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
			delete data.data.doctors
			try {
				//trying to find a use case for transducers (customized reducers)
				const { laboratories } = data.data
				const mapping = (fn) => (result, input) => {
					result.push(fn(input))
					return result
				}
				const justrace = (result, input) => { 
					trace(input)
					result.push(input)
					return result
				}
				const actions = compose(justrace, trace, mapping(buildLab))
				console.log(laboratories.reduce(actions, []))
			} catch (x) { }
			return data.data
		})
		.then(entities => context.commit('set_entities', entities))
		.then(() => context.state.fetchRequestMade = true)
		.catch(VuexError('Error Fetching Health Service Entities.'))
	}
}

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}