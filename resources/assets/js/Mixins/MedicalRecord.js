const MedicalRecordsMixin = {
	data() { return {
		errors: {},
	}},
	props: {
		formData: { type: Object, default: {}, required: true}
	},
	mounted () {
		console.log(this.$store.getters.accountType)
		console.log('help')
		// console.group('MedicalRecords')
		// console.log(this.$props.formData)
		// console.groupEnd('MedicalRecords')
		this.form = _.extend({}, this.$props.formData)
	},
	computed: {
		isUpdating() {
			return !_.isEmpty(this.formData)
		}
	},
	methods: {
		create() {
			const { form, getErrors } = this
			this.submit().then(resp => this.$emit('success', resp.data.data))
				.then(() => (this.form = {}))
				.catch(getErrors)
				.then(err => {
					if (err.response)
					this.$emit('error', err.response.data)
				})
		},
		async submit() {
			const { isUpdating, form } = this
			try {
				return await (!isUpdating)
					? this.$http.post(this.endpoints.create, form) 
					: this.$http.patch(this.endpoints.update.replace('{id}', form.id), form)       
			} catch (x) { console.warn(x) }
		},
		getErrors(error) {
			console.log(error)
			this.errors = error.response.data.errors
			return error
		}
	}
}

export default MedicalRecordsMixin