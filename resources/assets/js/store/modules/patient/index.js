import _ from 'lodash'
import axios from 'axios'
import { VuexError, urlGenerator, categorizeShares, 
		guessDataKey, shareFactory, extractRecords, 
		personalify } from '@/store/helpers/utilities'

const emergency = urlGenerator('emergency_contacts')

const state = {
	shares_loading: true,
	shares: {
		hospitals: [],
		doctors: []
	},
	share_extensions: [],
	contacts: [],
	children: []
}

const getters = {
	allShares: (store) => _.merge(store.shares, store.share_extensions)
}

const mutations = {
	set_shares: (store, payload) => store.shares = payload,
	set_contacts: (store, payload) => store.contacts = payload,
	set_children: (store, payload) => store.children = payload,
	set_share_extensions: (store, payload) => store.share_extensions = payload
}

const actions = {
	async approveShare (context, share_id) {
		axios.patch(`/api/patient/profile/share-extensions/${share_id}/approve`)
		.then(() => context.dispatch('FETCH_ALL_SHARES'))
		.catch(VuexError('Error Accepting Share Extension'))
	},
	async expireShare (context, share_id) {
		axios.patch(`/api/patient/profile/shares/${share_id}/expire`)
		.then(() => context.dispatch('FETCH_ALL_SHARES'))
	},
	async declineShare (context, share_id) {
		axios.patch(`/api/patient/profile/share-extensions/${share_id}/decline`)
		.then(() => context.dispatch('FETCH_ALL_SHARES'))
		.catch(VuexError('Error Accepting Share Extension'))
	},
	async EXTEND_SHARE(context, payload) {
		try {
			const {data} = await axios.patch(`/api/patient/profile/shares/${payload.id}/extend`, payload.data)
			context.dispatch('FETCH')
			return data
		} catch (x) {
			VuexError('Profile Share Extension Updated')()
			throw Error(x)
		}
	},
	//PROFILE SHARES
	FETCH (context) {
		axios.get('/api/patient/profile/shares').then(( {data} ) => {
			context.state.shares_loading = false
			context.commit('set_shares', categorizeShares(data.shares.map(shareFactory)))
		}).catch(VuexError('An Error Occured. Trying to fetch Patient Shares!'))
	},
	FETCH_PENDING() {
		axios.get('/api/patient/profile/shares/pending').then(({data}) => {
			console.log('pending shares', data.shares)
		}).catch(VuexError('An Error Occured. Trying to fetch Pending Shares'))
	},
	FETCH_EXTENSION (context) {
		axios.get('/api/patient/profile/share-extensions').then(({data}) => {
			context.commit('set_share_extensions', categorizeShares(data.data.map(shareFactory)))
		}).catch(VuexError('Error Fetching Share Extension'))
	},
	FETCH_ALL_SHARES (context) {
		context.dispatch('FETCH')
		context.dispatch('FETCH_EXTENSION')
	},
	//CONTACTS
	FETCH_CONTACTS (context) {
		axios.get(emergency(context).base()).then(guessDataKey).then(({data}) => {
			context.commit('set_contacts', extractRecords(data) )
		}).catch(VuexError('Error retrieving Emergency Contacts'))
	},
	CREATE_CONTACT (context, payload) {
		axios.post(emergency(context).base(), payload).then(() => {
			context.dispatch('FETCH_CONTACTS')
		}).catch(VuexError('Error creating Emergency Contact'))
	},
	UPDATE_CONTACT (context, payload) {
		axios.put(emergency(context).update(payload.id), payload).then(() => {
			context.dispatch('FETCH_CONTACTS')
		}).catch(VuexError('Error Updating Emergency Contact'))
	},
	DELETE_CONTACT (context, payload) {
		axios.delete(emergency(context).delete(payload)).then(() => {
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
	async addChild (context, payload) {
		try {
			const {data} = await axios.post('/api/patient/children', payload)
			context.dispatch('FETCH_CHILDREN')
			return data.message
		} catch (x) {
			VuexError('Error adding child')()
			throw x
		}
	},
	async unlinkChild (context, id) {
		try {
			const {data} = await axios.post('/api/patient/children/unlink', {id})
			context.dispatch('FETCH_CHILDREN')
			return data.message
		} catch (x) {
			VuexError('Error unlinking child')()
			throw x.response.data
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