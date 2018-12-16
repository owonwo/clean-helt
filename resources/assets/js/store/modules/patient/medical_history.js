import axios from 'axios'
import { VuexError, extractRecords } from '@/store/helpers/utilities'

const state = {
	/**
	  *@type <Array[{disease:"string", carriers: <Array["string"]> }]>
	  */
	histories: [],
	allergies: [],
	hospitalizations: [],
	immunizations: [],
}

const getters = {
	getMedicalHistories: (store) => store.histories
}

const mutations = {
	set_allergies (store, payload) {
		store.allergies = payload
	},
	set_hospitalizations(store, payload) {
		store.hospitalizations = payload 
	},
	set_immunization (store, payload) {
		store.immunizations = payload
	},
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
			context.commit('set_histories', extractRecords(res.data.data))
		}).catch(VuexError('Fetching Medical Histories Failed'))
	},
	FETCH_ALLERGIES(context) {
		axios.get('/api/patient/record/allergy').then(({data}) => {
			context.commit('set_allergies', extractRecords(data.data))
		}).catch(VuexError('Error Fetching Allergies'))
	},
	// HOSPITALIZATIONS
	FETCH_HOSPITALIZATIONS(context) {
		axios.get('/api/patient/record/hospitalization').then(({data}) => {
			context.commit('set_hospitalizations', extractRecords(data.data))
		}).catch(VuexError('Error Fetching Hospitalizations'))		
	},

	// IMMUNIZATIONS
	FETCH_IMMUNIZATIONS(context) {
		console.log(context.rootState.manage_patient.currentPatient)
		axios.get('/api/patient/record/immunization').then(({data}) => {
			context.commit('set_immunization', extractRecords(data.data))
		}).catch(VuexError('Error Fetching immunizations'))		
	}
}

export default {
	namespaced: true,
	state, 
	getters, 
	mutations,
	actions
}