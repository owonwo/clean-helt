import _ from 'lodash'
import axios from 'axios'
import { personalify } from '@/store/helpers/utilities'

const state = {
	ACCOUNT_TYPE: '',
	user: {
		avatar: '',
		age: 0
	},
	notifications: [],
	settings: {
		notification: true,
	},
	get isAdult() {
		return this.user.age >= 18
	},
}

const getters = {
	getUser: (store) => store.user,
	notifs: (store) => store.notifications,
	accountType: (store) => store.ACCOUNT_TYPE,
	isAdult: (store) => store.isAdult,
	isChild: (store) => !store.isAdult,
}

const mutations = {
	set_notifs(store, payload) {
		store.notifications = payload
	},
	set_account_type (store, payload) {
		store.ACCOUNT_TYPE = payload
	},
	set_user: (store, payload) => store.user = _.extend(store.user, payload),
	set_config: (store , payload) => store.settings = _.extend(store.settings, payload),
	set_avatar(store, payload) {
		store.user.avatar = payload
	}
}

const actions = {
	ACCEPT_SHARE(context, share_id) {
		const payload = { account: context.state.ACCOUNT_TYPE, share_id }
		context.dispatch('manage_patient/ACCEPT_SHARE', payload)
	},
	FETCH_USER_DATA (context) {
		const {route, key} = context.state.settings.profile
		axios.get(route)
			.then((res) => _.extend(res.data[key]))
			.then(personalify)
			.then((user_data) => context.commit('set_user', user_data))
	}
}

export default {
	state,
	getters,
	mutations,
	actions
}