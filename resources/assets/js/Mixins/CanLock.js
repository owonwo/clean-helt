export default {
	props: {
		editable: {
			type: Boolean,
			default: false,
		}
	},
	computed: {
		isLocked() {	
			return !this.isEditable
		},
		canEdit() {
			return this.$props.editable
		}
	}
}