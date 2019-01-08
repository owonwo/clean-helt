const MedicalRecordsMixin = {
	props: {
		formData: { type: Object, default: {}, required: true}
	},
	mounted () {
		this.updateForm()
	},
	watch: {
		formData() {
			this.updateForm()
		}
	},
	methods: {
		create() {
            this.$emit('submit', this.form)
        },
        updateForm() {
        	this.form = _.extend({}, this.$props.formData)
        }
	}
}

export default MedicalRecordsMixin