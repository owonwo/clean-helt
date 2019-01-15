import axios from 'axios'
import { VuexError, extractPatientFromShare } from '@/store/helpers/utilities'

const state = {
	patients: [],
	pendingPatients: [],
	currentPatient: {},
	fellow_doctors: []
}

const mutations = {
	set_current_patient: (store, payload) => {
		const share = store.patients.find(e => e.patient.id == payload)
		!share || (store.currentPatient = share.patient)
	},
	set_patients: (store, payload) => store.patients = payload,
	set_pending_patients: (store, payload) => store.pendingPatients = payload
}

const actions = {
	FETCH_PENDING_PATIENTS(context, account) {
		axios.get(`/api/${account}/patients/pending`)
			.then(({data}) => data.patients.map(extractPatientFromShare))
			.then(pending => context.commit('set_pending_patients', pending))
			.catch(VuexError('Pending Patients could not be fetched!'))
	},
	FETCH_ALL_PATIENTS(context, account) {
		context.dispatch('FETCH_PATIENTS', account)
		context.dispatch('FETCH_PENDING_PATIENTS', account)
	},
	FETCH_PATIENTS(context, account = '') {
		console.log(context, account)
		axios.get(`/api/${account}/patients`)
			.then(({data}) => data.patients.map(extractPatientFromShare))
			.then((patients) => context.commit('set_patients', patients))
			.catch(VuexError('Active Patients could not be fetched!'))
	},
	ACCEPT_SHARE (context, payload) {
		const { share_id, account } = payload
		const url = `/api/${account}/patients/pending/${share_id}/accept`
		axios.patch(url).then(() => {
			context.dispatch('FETCH_ALL_PATIENTS', account)
		}).catch(VuexError('Accept Failed!'))
	}
	// FETCH_PATIENT_DATA(context, medicalRecord) {
	// 	const { currentPatient: patient } = context.state
	// 	if (patient.chcode)
	// 	axios.get(`/api/doctor/patients/${patient.chcode}/records/${medicalRecord}`).then( ({data}) => {
	// 		console.log(data)
	// 	})
	// }
}

export default {
	namespaced: true,
	state,
	mutations,
	actions
}