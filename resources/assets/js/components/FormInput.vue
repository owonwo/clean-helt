<script>
export default {
	name: 'FormInput',
	props: ['type', 'placeholder', 'required', 'value'],
	render(h) {
		const props = {
			class: ['input'],
			attrs: this.$props,
			on: {
				keyup: (event) => this.$emit('value', event.target.value),
				change: (event) => {
					this.$emit('value', event.target.value)
					this.$emit('change', event)
				}
			}
		}
		return h('div', {class: 'field'}, [
			h('input', props)
		])
	},
}
</script>