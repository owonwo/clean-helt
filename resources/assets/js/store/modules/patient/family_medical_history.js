import axios from 'axios' 
import { VuexError, extractRecords } from '@/store/helpers/utilities'

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
		return axios.post('/api/patient/record/family-history', payload)
			.catch(VuexError('Failed Creating Disease'))
	},
	DELETE_DISEASE (context, payload) {
		return axios.delete(`/api/patient/record/family-history/${payload.id}`)
			.catch(VuexError('Failed to Delete Disease'))
	},
	UPDATE_DISEASE (context, payload) {
		return axios.patch(`/api/patient/record/${payload.id}/family-history`, payload)
			.catch(VuexError('Failed Updating Disease'))
	},
	FETCH_DISEASES (context) {
		return axios.get('/api/patient/record/family-history').then((res) => {
			context.commit('set_diseases', extractRecords(res.data.data) || [])
		}).catch(VuexError('Fetching Diseases Failed'))
	},
}

export default {
	state, 
	getters, 
	mutations,
	actions
}