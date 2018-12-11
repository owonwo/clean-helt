import _ from 'lodash'

export default {
	data() {
		return { form : {} }
	},
	mounted() { 
		this.$store.dispatch( this.crud.read.action )
	},
	methods: {
		validate() {
			return false
		},
		create() {
			const { action, message } = this.crud.create

			!this.validate() ? console.warn(`Form validation failed!`) :
			this.$store.dispatch(action, this.form)
				.then(() => {
					this.success_message(message.success)
					this.form = {}
				}).catch(() => this.error_message(message.error))
		},
		update(payload = {}) {
			const { action, message } = this.crud.update
			this.$store.dispatch(action, payload)
				.then(() => this.success_message(message.success))
		},
		trash(id) {
			const { action, message } = this.crud.delete

			this.$store.dispatch(action, id)
				.then(() => this.success_message(message.success))
				.then(() => this.opened = false)
		}
	}
}