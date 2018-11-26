import axios from 'axios'
import { VuexError } from '@/store/helpers/utilities'

const state = {
	/**
	  *@type <Array[{disease:"string", carriers: <Array["string"]> }]>
	  */
	histories: [],
}

const getters = {
	getMedicalHistories: (store) => store.histories
}

const mutations = {
	set_histories (store, payload) {
		store.histories = payload
	},
}

const actions = {
	// CREATE_DISEASE (context, payload) {
	// 	return axios.post('/api/patient/record/family-history', payload)
	// 		.catch(VuexError('Failed Creating Disease'))
	// },
	// DELETE_DISEASE (context, payload) {
	// 	return axios.delete(`/api/patient/record/family-history/${payload.id}`)
	// 		.catch(VuexError('Failed to Delete Disease'))
	// },
	// UPDATE_DISEASE (context, payload) {
	// 	return axios.patch(`/api/patient/record/${payload.id}/family-history`, payload)
	// 		.catch(VuexError('Failed Updating Disease'))
	// },
	FETCH_MEDICAL_HISTORY (context) {
		return axios.get('/api/patient/record/medical-history').then((res) => {
			context.commit('set_histories', res.data.data)
		}).catch(VuexError('Fetching Medical Histories Failed'))
	},
}

export default {
	namespaced: true,
	state, 
	getters, 
	mutations,
	actions
}