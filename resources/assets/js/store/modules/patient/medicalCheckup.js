import axios from 'axios'
import { VuexError, extractRecords, urlGenerator, guessDataKey } from '@/store/helpers/utilities'

const checkup = urlGenerator('medical_checkup')

const state = {
	checkups: []
}

const getters = {
}

const mutations = {
	set_checkups: (store, payload) => store.checkups = payload 
}

const actions = {
	FETCH_MEDICAL_CHECKUPS (context) {
		axios.get(checkup(context).base())
		.then(res => extractRecords(res.data.records))
		.then(data => context.commit('set_checkups', data))
		.catch(VuexError('Error Fetching Medical Checkups'))
	},
	async CREATE_MEDICAL_CHECKUP (context, payload) {
		try {
			const {data} = await axios.post(checkup(context).base(), payload)
			return data
		} catch (x) {
			VuexError('Error Creating Medical Checkup')(x)
			throw x.response.data.errors
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