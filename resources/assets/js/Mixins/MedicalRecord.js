const MedicalRecordsMixin = {
	props: {
		formData: { type: Object, default: {}, required: true}
	},
	mounted () {
		this.form = _.extend({}, this.$props.formData)
	},
	computed: {
		// isUpdating() {
		// 	return !_.isEmpty(this.formData)
		// }
	},
	methods: {
		create() {
            this.$emit('submit', this.form)
        },
		// create() {
		// 	const { form, getErrors } = this
		// 	this.submit().then(resp => this.$emit('success', resp.data.data))
		// 		.then(() => (this.form = {}))
		// 		.catch(getErrors)
		// 		.then(err => {
		// 			if (err.response)
		// 			this.$emit('error', err.response.data)
		// 		})
		// },
		// async submit() {
		// 	const { endpoints, isUpdating, form } = this
		// 	try {
		// 		return await (!isUpdating)
		// 			? this.$store.dispatch(endpoints.create, form) 
		// 			: this.$store.dispatch(endpoints.update, { form, id: form.id })       
		// 	} catch (x) { console.warn(x) }
		// },
		// getErrors(error) {
		// 	console.log(error)
		// 	this.errors = error.response.data.errors
		// 	return error
		// }
	}
}

export default MedicalRecordsMixin