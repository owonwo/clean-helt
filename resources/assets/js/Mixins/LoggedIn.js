import { mapGetters, mapMutations } from 'vuex'
import { createUserNotification, getNotificationRoute } from '@/store/Helpers.js'
const ServiceProviders = ['hospital', 'doctor', 'pharmacy', 'laboratory']

export default {
	props: ['id'],
	data() {return {
	}},
	created() {
		//create the token for the application
		const token = localStorage.getItem('api-token')//$('meta[name=api-token]').attr('content');

		//checks if the user is valid
		if(!this.testChCode(this.$props.id) || typeof this.$props.id === 'undefined' || this.$props.id === '') 
			console.warn('Logged In User ChCode is invalid!, So features are bound to fail')
		if(!_.isUndefined(token) && 'string' === typeof token) {
			window.axios.defaults.headers.common = {
				'Authorization': `Bearer ${token}`,
			}
		}else{
			console.warn('The Logged In User has got no token!')
		}
	},
	mounted() {
		//for profiles
		const {profile, patients} = this.settings
		if('undefined' !== typeof profile.route)
			try {
				this.$http.get(profile.route).then((res) => {
					const USER_DATA = _.extend(this.user, res.data[profile.key])
					this.set_user(USER_DATA)
				})
				//for services providers
				this.$store.commit('set_account_type', this.componentName)
			}catch(x) {
				console.warn('Account Error: invalid profile route.')
			}
		this.fetchNotifications()
		!ServiceProviders.includes(this.componentName) || this.fetchPatients()
	},
	computed: {
		...mapGetters(['accountType']),
		...mapGetters({user: 'getUser', pendingUsers:'getPendingUsers'}),
		/**
         * @return String
         */
		componentName() { return this.getComponentName().toLowerCase() }
	},
	methods: {
		...mapMutations([
			'set_user', 
			'set_notifs',
			'set_pending_patients', 
			'remove_from_pending', 
			'set_shared_profiles'
		]),
		//gets the name of the component attached to
		getComponentName() {
			return 'undefined' !== typeof this.$vnode ? this.$vnode.componentOptions.tag : 'ADMIN'
		},
		//accept pending shares
		async acceptShare(id) {
			const url = `/api/${this.componentName}/patients/pending/${id}/accept`
			return await this.$http.patch(url).then(() => {
				this.remove_from_pending(id)
				this.fetchPatients()
			}).catch(() => {
				console.log('Accept Failed!')
			})
		},
		// fetches both pending and active patients
		fetchPatients() {
			let {patients} = this.settings
                
			this.$http.get(`/api/${this.componentName}/patients/pending`).then((res) => {
				const PATIENTS = res.data.patients
				let found = (!!PATIENTS)
				found
					? this.set_pending_patients(PATIENTS)
					: console.assert(found, 'Pending Patients could not be fetched!')
			})

			if(patients.route)
				this.$http.get(patients.route).then((res) => {
					const PATIENTS = res.data[patients.key]
					this.set_shared_profiles(PATIENTS)
				})
		},
		// creates a logout form and submit it.
		logout() {
			let input = document.createElement('input')
			input.value = $('meta[name=csrf-token]').attr('content')
			input.name = '_token'
			let form = $('<form></form>')
			let route = this.getComponentName() === 'ADMIN' ? '/admin/logout' : '/logout'
			form.attr('action', route).attr('method', 'POST').append(input).submit()
			$('body').append(form)
			this.clearApiToken()
			form.submit() 
		},
		//clears the api tokens created at login time
		clearApiToken() {
			localStorage.removeItem('api-token')
			localStorage.removeItem('refresh-token')
		},
		fetchNotifications() {
			const accountType = this.accountType.toUpperCase(),
				url = getNotificationRoute(accountType)

			console.assert(url, 'The Notification Url is invalid')
			this.$http.get(url.all).then(({data}) => {
				const notificationList = data.notification.data
					.map(createUserNotification(accountType))
				this.set_notifs(notificationList)
			}).catch(err => console.warn('The Notification Module Failed with error:', err));
		}
	},
}
