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

export const APPEND_CRUD_METHODS = (record) => {
	const __methods = {
		isEditing: false,
		toggleEdit() {
			return (this.isEditing = !this.isEditing)
		}
	}
	return __.assign({}, __methods, record)
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
	const pickName = () => {
		console.log(share)
		let {first_name, last_name, name} = share.provider
		return share.provider_type === 'App\\Models\\Doctor' 
			? `Dr ${first_name} ${last_name}` : name 
	}
	const  overwrites = {
		provider_type: share.provider_type.replace('App\\Models\\', ''),
		status: Number(share.status),
		provider: Object.assign(share.provider, { name: pickName() }),
	}
	return Object.assign({visible: true}, share, overwrites)
}