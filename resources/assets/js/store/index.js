import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

//freeze the profile object after adding
//user mixin
const lockProfile = (profile) => {
	profile.patient = _.extend(Object.create({
        get name () {
        	return [this.first_name,this.last_name].join(' ');
        },
        get fullname () {
        	return [this.first_name, this.middle_name, this.last_name].join(' ');
        },
        get full_name() {
        	return this.fullname;
        }
	}), profile.patient);

	return Object.freeze(profile);
}

export default new Vuex.Store({
	state: {
		user: {
            first_name: "",
            last_name: "",
            profile: {},
            get full_name() {
                return [this.first_name, this.last_name].join(' ')
            }
        },
        ACCOUNT_TYPE: "",
        pending: [],
		sharedProfiles: [],
		settings: {
			notification: true,
		},
	},
	getters: {
		getUser: (store) => store.user,
		getProfileByPatientId: store => id => {
			return _.find(store.sharedProfiles, profile => profile.patient.id === parseInt(id));
		},
		accountType: store => store.ACCOUNT_TYPE,
		getPendingUsers: store => {
			return store.pending;
		}
	}, 
	actions: {
		
	},
	mutations: {
		set_account_type (store, payload) {
			store.ACCOUNT_TYPE = payload;
		},
		set_shared_profiles(store, payload) {
			store.sharedProfiles = payload.map(profile => lockProfile(profile));
		},
		remove_from_pending(store, payload) {
			store.pending = _.remove(store.pending, (e) => e.id !== payload);
		},
		set_user (store, payload) {
			store.user = _.extend(store.user, payload);
		},
		set_pending_patients(store, payload) {
			store.pending = payload;
		}
	},
});
