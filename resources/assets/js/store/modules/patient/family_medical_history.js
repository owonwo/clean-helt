import axios from 'axios' 
import { VuexError, extractRecords, urlGenerator, guessDataKey } from '@/store/helpers/utilities'

const familyHistory = urlGenerator('family_history')

const state = {
	/**
	  *@type <Array[{disease:"string", carriers: <Array["string"]> }]>
	  */
	diseases: [],
}

const getters = {
	getDiseases: (store) => store.diseases
}

const mutations = {
	set_diseases(store, payload) {
		store.diseases = payload
	},
}

const actions = {
	UPDATE_DISEASES (context) {
		context.state.diseases.forEach(disease => {
			typeof disease.id === 'undefined' ?
				context.dispatch('CREATE_DISEASE', disease)
				: context.dispatch('UPDATE_DISEASE', disease)
		})
	},
	CREATE_DISEASE (context, payload) {
		return axios.post(familyHistory(context).base(), payload)
			.catch(VuexError('Failed Creating Disease'))
	},
	DELETE_DISEASE (context, payload) {
		return axios.delete(familyHistory(context).delete(payload.id))
			.catch(VuexError('Failed to Delete Disease'))
	},
	UPDATE_DISEASE (context, payload) {
		return axios.patch(familyHistory(context).update(payload.id), payload)
			.catch(VuexError('Failed Updating Disease'))
	},
	FETCH_DISEASES (context) {
		return axios.get(familyHistory(context).base()).then(guessDataKey)
		.then(({data}) => {
			context.commit('set_diseases', extractRecords(data))
		}).catch(VuexError('Fetching Diseases Failed'))
	},
}

export default {
	namespaced: true,
	state, 
	getters, 
	mutations,
	actions
}