import axios from 'axios'
import { VuexError, extractRecords } from '@/store/helpers/utilities'

const state = {
	contacts: [],
	fetchRequestMade: false,
}

const getters = {
	loading: (store) => !store.fetchRequestMade,
}

const mutations = {
	set_contacts: (store, payload) => store.contacts = payload,
}

const actions = {
	FETCH(context) {
		return axios.get('/api/patient/record/hospital-contact').then(({data}) => {
			context.state.fetchRequestMade = true
			context.commit('set_contacts', extractRecords(data.data))
		}).catch(VuexError('Error Fetching Hospital Contacts.'))
	},
	async UPDATE(context, payload) {
		try {
			const data = await axios.patch(`/api/patient/record/hospital-contact/${payload.id}`, payload)
			context.dispatch('FETCH')
			return data
		} catch (x) {
			VuexError('Updating Hospital Contact failed')()
			throw Error(x)
		}

	},
	async DELETE(context, id) {
		try {
			const data = await axios.delete(`/api/patient/record/hospital-contact/${id}`,)
			const changes = context.state.contacts.filter(e => id !== e.id)
			context.commit('set_contacts', changes)
			return data
		} catch (x) {
			VuexError('Error Fetching Hospital Contacts.')()
			throw x
		}
	},
	async CREATE(context, payload) {
		try {
			const {data: res} = await axios.post('/api/patient/record/hospital-contact', payload)
			// const {contacts} = context.state
			// contacts.push({...payload, ...res.data})
			context.dispatch('FETCH')
		} catch (x) {
			VuexError('Error Fetching Hospital Contacts.')()
			throw Error(x)
		}
	},
}

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}