import moment from 'moment'

const __ = Object

export const VuexError = (message) => err => console.error(err, `(source) vuex : ${message}`)

// Object.freeze the patient profile
export const lockProfile = (person) => {
	return __.freeze(personalify(person))
}

// Extracts the Medical Record Data from Ajax payload
export const extractRecords = (record = []) => {
	return record.map(e => e.data).filter(e => e !== null).map(APPEND_CRUD_METHODS)
}

const __crud__methods = {
	isEditing: false,
	toggleEdit() {
		return (this.isEditing = !this.isEditing)
	}
}

export const REMOVE_CRUD_METHODS = (record) => {
	Object.keys(__crud__methods).forEach(e => delete record[e])
	return record
}

export const APPEND_CRUD_METHODS = (record) => {
	return __.assign({}, __crud__methods, record)
}

export const extractPatientFromShare = (share) => {
	share.patient = personalify(share.patient) 
	return share
}

export const personalify = (person) => {
	const person_proto = {
		get name () {
			return [this.first_name,this.last_name].join(' ').trimEnd()
		},
		get fullname () {
			return [this.first_name, this.middle_name, this.last_name].join(' ').trimEnd()
		},
		get age() {
			return Math.abs( moment(Date.now()).year() - moment(this.dob).year() )
		},
		get full_name() {
			return this.fullname
		}
	}

	return __.assign(__.create(person_proto), person)
}

export const delay = (time) => (result) => new Promise(resolve => setTimeout(() => resolve(result), time))

export const shareFactory = (share)  => {
	console.log(share)
	const pickName = () => {
		let {first_name, last_name, name} = share.provider
		return share.provider_type === 'App\\Models\\Doctor' 
			? `Dr ${first_name} ${last_name}` : name 
	}
	const  overwrites = {
		provider_type: share.provider_type.replace('App\\Models\\', ''),
		status: Number(share.status),
		provider: __.assign(share.provider, { name: pickName() }),
	}
	return __.assign({visible: true}, share, overwrites)
}

const lab_proto = {
	offers: '',
	services() {
		return this.offers.split(',')
	}
}

export const buildLab = (lab) => {
	// return __.assign(__.create(lab_proto), lab)
	return lab
}

export const trace = (x) => console.log(x)

export const guessDataKey = ({data}) => {
	data.data || (data.data = data['records'])
	return data
}

export const urlGenerator = (routeGroup) => {
	const routes = { 
		allergies, 
		immunization,
		family_history, 
		health_insurance,
		hospital_contact,
		emergency_contacts,
		medical_history,
		hospitalization 
	}

	return routes[routeGroup]
}

const health_insurance = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		update: (id) => `/api/patient/record/health-insurance/${id}`,
		delete(id) {
			return `/api/patient/record/${id}/health-insurance`
		},
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/health-insurance`
			: '/api/patient/record/health-insurance'
		}
	}	
}

const hospital_contact = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		update: (id) => `/api/patient/record/hospital-contact/${id}`,
		delete(id) {
			return this.update(id)
		},
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/hospital-contacts`
			: '/api/patient/record/hospital-contact'
		}
	}	
}

const emergency_contacts = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		update: (id) => `/api/patient/record/emergency-contacts/${id}`,
		delete(id) {
			return this.update(id)
		},
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/emergency-contacts`
			: '/api/patient/record/emergency-contacts'
		}
	}	
}
const medical_history = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/medical-history`
			: '/api/patient/record/medical-history'
		}
	}	
}
const allergies = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		update(id) {
			return isDoctor ? this.base() + `/${id}`
			: `/api/patient/update/${id}/allergy`
		},
		delete(id) {
			return this.update(id)
		},
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/allergies`
			: '/api/patient/record/allergy'
		}
	}	
}

const hospitalization = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		base: () => isDoctor
			? `/api/doctor/patients/${patient.chcode}/hospitalizations`
			: '/api/patient/record/hospitalization'
	}
}

const immunization = ({rootGetters, rootState}) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient
	
	return {
		update(id) {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/immunizations/${id}`
			: `/api/patient/update/${id}/immunization`
		},
		delete(id) {
			return this.update(id)
		},
		base: () => isDoctor
			? `/api/doctor/patients/${patient.chcode}/immunizations`
			: '/api/patient/record/immunization'
	}
}

const family_history = ({ rootGetters, rootState} ) => {
	const isDoctor = rootGetters.accountType === 'doctor'
	const {currentPatient: patient} = rootState.manage_patient

	return {
		update(id) {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/family-records/${id}`  
			: `/api/patient/record/${id}/family-history`
		},
		delete(id) {
			return this.base() + `/${id}`
		},
		base() {
			return isDoctor 
			? `/api/doctor/patients/${patient.chcode}/family-records`
			: '/api/patient/record/family-history'
		}
	}
}