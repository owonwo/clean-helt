const routes = {
	DOCTOR: {
		all: '/api/doctor/notifications',
		unread: '/api/doctor/notification/unread',
	},
	PATIENT: {
		all: '/api/patient/notifications',
		unread: '/api/patient/notification/unread',
	},
	PHARMACY: {
		all: '/api/pharmacy/notifications',
		unread: '/api/pharmacy/notification/read',
	},
	HOSPITAL: {
		all: '/api/hospital/notifications',    
		unread: '/api/hospital/notification/unread',
	},
	LABORATORY: {
		all: '/api/laboratory/notifications',
		unread: '/api/laboratory/notification/read',
	}
};

/**
  *@return Object
  */
export const getNotificationRoute = (model) => {
	model = model.toUpperCase()
	const modelFound = Object.keys(routes).includes(model)
	console.assert(modelFound, 'Invalid Model supplied for Notification Model')
	return (modelFound ? routes[model] : routes['PATIENT'])
}

const notification_prototype = Object.create({
	constructor: 'Notification',
	read: false,
	message: 'Empty',
	/** sets a notification to read */
	async isRead() {
		return window.axios.get(getNotificationRoute(this.model) + '/' + this.id)
	},
})

/**
 *Notification singleton
 *@return Notificaiton
 */
const notificationFactory = (notif = {}, model) => {
	const __proto = Object.assign(notification_prototype, {
		id: notif.id, 
		model,
		data: notif.data,
		read: !_.isNull(notif.read_at),
		message: notif.data
	})

	return {
		make() {
			return __proto
		}
	}
}

// UserNotificationComposition
export const createUserNotification = (account) => (notif) => notificationFactory(notif, account).make()

export default {
	getNotificationRoute,
	createUserNotification
}