import axios from 'axios'
import { VuexError, extractRecords, urlGenerator, guessDataKey } from '@/store/helpers/utilities'

const hospital_contact = urlGenerator('hospital_contact')

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
		return axios.get(hospital_contact(context).base()).then(guessDataKey)
		.then(({data}) => {
			context.state.fetchRequestMade = true
			context.commit('set_contacts', extractRecords(data))
		}).catch(VuexError('Error Fetching Hospital Contacts.'))
	},
	async UPDATE(context, payload) {
		try {
			const data = await axios.patch(hospital_contact(context).update(payload.id), payload)
			context.dispatch('FETCH')
			return data
		} catch (x) {
			VuexError('Updating Hospital Contact failed')()
			throw Error(x)
		}

	},
	async DELETE(context, id) {
		try {
			const data = await axios.delete(hospital_contact(context).delete(id))
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
			await axios.post(hospital_contact(context).base(), payload)
			context.dispatch('FETCH')
			return 
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