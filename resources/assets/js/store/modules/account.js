import _ from 'lodash'
import axios from 'axios'
import moment from 'moment'

const state = {
	ACCOUNT_TYPE: '',
	user: {
		avatar: '',
		get age() {
			return Math.abs( moment(Date.now()).year() - moment(this.dob).year() )
		},
		get full_name() {
			return [this.first_name, this.last_name].join(' ')
		}
	},
	notifications: [],
	settings: {
		notification: true,
	}
}

const getters = {
	getUser: (store) => store.user,
	isChild: (store) => !store.isAdult,
	notifs: (store) => store.notifications,
	isAdult: (store) => store.user.age >= 18,
	accountType: (store) => store.ACCOUNT_TYPE
}

const mutations = {
	set_notifs(store, payload) {
		store.notifications = payload
	},
	set_account_type (store, payload) {
		store.ACCOUNT_TYPE = payload
	},
	set_user (store, payload) {
		store.user = _.extend(store.user, payload)
	},
	set_avatar(store, payload) {
		store.user.avatar = payload
	}
}

const actions = {
	ACCEPT_SHARE(context, share_id) {
		const payload = { account: context.state.ACCOUNT_TYPE, share_id }
		context.dispatch('manage_patient/ACCEPT_SHARE', payload)
	},
	FETCH_USER_DATA (context, {route, key}) {
		axios.get(route)
			.then((res) => _.extend(context.state.user, res.data[key]))
			.then((user_data) => context.commit('set_user', user_data))
	}
}

export default {
	state,
	getters,
	mutations,
	actions
}