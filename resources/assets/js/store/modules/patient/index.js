import axios from 'axios'
import { VuexError, shareFactory, extractRecords } from '@/store/helpers/utilities'

const state = {
	shares: {
		hospitals: [],
		doctors: []
	},
	contacts: []
}

const mutations = {
	set_shares: (store, payload) => store.shares = payload,
	set_contacts: (store, payload) => store.contacts = payload
}

const actions = {
	FETCH (context) {
		axios.get('/api/patient/profile/shares').then(( {data} ) => {
			console.log(data.shares.map(shareFactory))
			// context.commit('set_shares', res.data.shares.map(shareFactory))
		}).catch(VuexError('An Error Occured. Trying to fetch Patient Shares!'))
	},
	FETCH_PENDING() {
		axios.get('/api/patient/profile/shares/pending').then(({data}) => {
			console.log(data.shares)
		}).catch(VuexError('An Error Occured. Trying to fetch Pending Shares'))
	},
	FETCH_CONTACTS (context) {
		axios.get('/api/patient/record/emergency-contacts').then(({data}) => {
			context.commit('set_contacts', extractRecords(data.data) )
		}).catch(VuexError('Error retrieving Emergency Contacts'))
	},
	CREATE_CONTACT (context, payload) {
		axios.post('/api/patient/record/emergency-contacts', payload).then(() => {
			context.dispatch('FETCH_CONTACTS')
		}).catch(VuexError('Error creating Emergency Contact'))
	},
	UPDATE_CONTACT (context, payload) {
		axios.put(`/api/patient/record/emergency-contacts/${payload.id}`, payload).then(() => {
			context.dispatch('FETCH_CONTACTS')
		}).catch(VuexError('Error Updating Emergency Contact'))
	},
	DELETE_CONTACT (context, payload) {
		axios.delete(`/api/patient/record/emergency-contacts/${payload}`).then(() => {
			context.dispatch('FETCH_CONTACTS')
		}).catch(VuexError('Error deleting Emergency Contact'))
	}
}

export default {
	namespaced: true,
	state,
	mutations,
	actions
}