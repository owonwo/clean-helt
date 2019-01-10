export default {
	props: {
		canEdit: {
			type: Boolean,
			default: false,
		}
	},
	computed: {
		isLocked() {	
			return !this.isEditable
		}
	}
}