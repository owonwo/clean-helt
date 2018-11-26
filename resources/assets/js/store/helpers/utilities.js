export const VuexError = (message) => err => console.warn(err, `(source) vuex : ${message}`)

//freeze the profile object after adding
//user mixin
export const lockProfile = (profile) => {
	profile.patient = Object.assign(Object.create({
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