import _ from 'lodash'

const state = {
	ACCOUNT_TYPE: '',
	user: {
		avatar: '',
		profile: {},
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
	notifs: (store) => store.notifications,
	accountType: store => store.ACCOUNT_TYPE,
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
	}
}

export default {
	state,
	getters,
	mutations,
	actions
}