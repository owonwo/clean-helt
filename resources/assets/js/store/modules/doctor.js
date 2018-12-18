import axios from 'axios'
import { VuexError } from '@/store/helpers/utilities'

const state = {
	pendingHospitals: [],
	sentHospitals: [],
	hospitals: [],
	fellow_doctors: []
}

const getters = {

}

const mutations = {
	set_hospitals: (state, payload) => state.hospitals = payload,
	set_sent_hospitals: (state, payload) => state.sentHospitals = payload,
	set_pending_hospitals: (state, payload) => state.pendingHospitals = payload,
	set_clients: (state, payload) => state.clients = payload,
}

const actions = {
	async fetchHospitals(context) {
		axios.get('/api/doctor/active-hospitals').then(res => {
			context.commit('set_hospitals', res.data.hospitals)
		})
	},
	manageHospital (context, hospital, type = '') {
		const actions = {
			accept: `/api/doctor/${hospital.chcode}/accept-hospital`,
			decline: `/api/doctor/${hospital.chcode}/decline-hospital`,
			remove: `/api/doctor/${hospital.chcode}/remove-hospital`,
		}
		this.$http.patch(actions[type]).then(() => {
			this.fetchHospitals()
		})
	},
	async fetchSentHospitals (context) {
		axios.get('/api/doctor/sent-hospitals').then((res) => {
			context.commit('set_sent_hospitals', res.data.hospitals)
		})
	},
	// fetchAllHospitals(context) {
	// 	context.commit('fetchSentHospital')
	// 	context.commit('fetchSentHospital')
	// 	context.commit('fetchActiveHospital')
	// },
	async fetchPendingHospitals (context) {
		axios.get('/api/doctor/pending-hospitals').then((res) => {
			context.commit('set_pending_hospitals', res.data.hospitals)
		})
	},
	FETCH_FELLOW_DOCTORS (context, payload) {
		axios.get('/doctors/').then(({data}) => {
			console.log(data)
		}).catch(VuexError('Error Fetching Fellow Doctors'))
	}
}

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions
}