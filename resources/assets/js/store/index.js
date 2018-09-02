import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

//freeze the profile object after adding
//user mixin
const lockProfile = (profile) => {
	profile.patient = _.extend(Object.create({
		/*** returns the fullname of the patient ***/
        fullname(with_middle = true) {
        	let middle_name = with_middle ? this.middle_name : "";
            return [this.first_name, middle_name,this.last_name].join(' ');
        },
        get full_name () {
        	return this.fullname(false);
        }
	}), profile.patient);

	return Object.freeze(profile);
}

export default new Vuex.Store({
	state: {
		user: {
            first_name: "",
            last_name: "",
            get full_name() {
                return [this.first_name, this.last_name].join(' ')
            }
        },
		sharedProfiles: [],
		settings: {
			notification: true,
		},
	},
	getters: {
		getProfileByPatientId: store => id => {
			return _.find(store.sharedProfiles, profile => profile.patient.id === id);
		}
	}, 
	actions: {
		
	},
	mutations: {
		set_shared_profiles(store, payload) {
			store.sharedProfiles = payload.map(profile => lockProfile(profile));
		},
		set_user (store, payload) {
			store.user = _.extend(store.user, payload);
		},
	},
});
