import axios from 'axios'
import { VuexError, shareFactory, extractRecords, personalify } from '@/store/helpers/utilities'

const state = {
	shares: {
		hospitals: [],
		doctors: []
	},
	contacts: [],
	children: []
}

const mutations = {
	set_shares: (store, payload) => store.shares = payload,
	set_contacts: (store, payload) => store.contacts = payload,
	set_children: (store, payload) => store.children = payload,
}

const actions = {
	//PROFILE SHARES
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
	//CONTACTS
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
	},
	//FAMILY RECORDS 
	FETCH_CHILDREN (context) {
		axios.get('/api/patient/children').then(({data}) => {
			const children = data.data.map(a => personalify(a.account))
			context.commit('set_children', children)
		}).catch(VuexError('Can\'t Fetch Children for Patient'))
	},
	retrieveToken (context, id) {
		axios.post('/api/patient/children/switch-account', {id}).then(({data}) => {
			localStorage.setItem('child-token', data.accessToken)
			window.location.reload()
		}).catch(VuexError('Error retrieving a child token'))
	},
	unlinkChild (context, id) {
		axios.post('/api/patient/children/switch-account', {id}).then(({data}) => {
			localStorage.setItem('child-token', data.accessToken)
			window.location.reload()
		}).catch(VuexError('Error retrieving a child token'))
	}
}

export default {
	namespaced: true,
	state,
	mutations,
	actions
}