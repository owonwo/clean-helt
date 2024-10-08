import Vue from 'vue'
import Vuex from 'vuex'
import _ from 'lodash'

import account from './modules/account'
import patient_share from './modules/patient'
import { lockProfile } from './helpers/utilities'
import medicalRecords from './modules/patient/medical_record'
import medicalCheckup from './modules/patient/medicalCheckup'
import health_insurance from './modules/patient/health_insurance'
import hospital_contacts from './modules/patient/hospital_contacts'
import service_providers from './modules/patient/service_providers'
import famMedicalHistory from './modules/patient/family_medical_history'

import doctor from './modules/doctor.js'
import hospital from './modules/hospital.js'
import manage_patient from './modules/manage_patient.js'

Vue.use(Vuex)
const medicalRecord = _.merge({}, medicalCheckup, medicalRecords, famMedicalHistory, health_insurance)

export default new Vuex.Store({
	modules: {
		doctor,
		account,
		patient_share,
		hospital,
		manage_patient,
		medicalRecord,
		health_insurance,
		hospital_contacts,
		famMedicalHistory,
		service_providers,
	},
	state: {
		pending: [],
	},
	getters: {
		getProfileByPatientId: store => id => {
			return _.find(store.sharedProfiles, profile => profile.patient.id === parseInt(id))
		},
		getPendingUsers: store => {
			return store.pending
		}
	}, 
	actions: {},
	mutations: {
		set_shared_profiles(store, payload) {
			store.sharedProfiles = payload.map(profile => lockProfile(profile))
		},
		remove_from_pending(store, payload) {
			store.pending = _.remove(store.pending, (e) => e.id !== payload)
		},
		set_pending_patients(store, payload) {
			store.pending = payload
		}
	},
})
