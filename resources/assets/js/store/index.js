import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios' 

Vue.use(Vuex)

//freeze the profile object after adding
//user mixin
const lockProfile = (profile) => {
	profile.patient = _.extend(Object.create({
		get name () {
        	return [this.first_name,this.last_name].join(' ')
		},
		get fullname () {
        	return [this.first_name, this.middle_name, this.last_name].join(' ')
		},
		get full_name() {
        	return this.fullname
		}
	}), profile.patient)

	return Object.freeze(profile)
}

const VuexError = (message) => err => console.warn(err, `(source) vuex : ${message}`)

export default new Vuex.Store({
	state: {
		user: {
			avatar: '',
			get full_name() {
				return [this.first_name, this.last_name].join(' ')
			}
		},
		ACCOUNT_TYPE: '',
		pending: [],
		sharedProfiles: [],
		notifications: [],
		/**
          *@type <Array[{disease:"string", carriers: <Array["string"]> }]>
          */
		diseases: [],
		settings: {
			notification: true,
		},
	},
	getters: {
		getUser: (store) => store.user,
		getProfileByPatientId: store => id => {
			return _.find(store.sharedProfiles, profile => profile.patient.id === parseInt(id))
		},
		notifs: (store) => store.notifications,
		accountType: store => store.ACCOUNT_TYPE,
		getPendingUsers: store => {
			return store.pending
		},
		getDiseases: (store) => store.diseases  
	}, 
	actions: {
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
				context.commit('set_diseases', res.data.data)
			}).catch(VuexError('Fetching Diseases Failed'))
		},
	},
	mutations: {
		set_diseases(store, payload) {
			store.diseases = payload
		},
		set_account_type (store, payload) {
			store.ACCOUNT_TYPE = payload
		},
		set_notifs(store, payload) {
			store.notifications = payload
		},
		set_avatar(store, payload) {
			store.user.avatar = payload
		},
		set_shared_profiles(store, payload) {
			store.sharedProfiles = payload.map(profile => lockProfile(profile))
		},
		remove_from_pending(store, payload) {
			store.pending = _.remove(store.pending, (e) => e.id !== payload)
		},
		set_user (store, payload) {
			store.user = _.extend(store.user, payload)
		},
		set_pending_patients(store, payload) {
			store.pending = payload
		}
	},
})
