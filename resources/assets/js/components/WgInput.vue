<script>
export default {
	name: 'WgInput',
	model: {
		prop: 'value',
		event: 'input'
	},
	props: ['type', 'placeholder', 'rows', 'col', 'label', 'required', 'value'],
	watch: {
		value(a) {
			const {input} = this.$refs
			if (input.type !== 'file') {
				input.value = a
			} 
		}
	},
	render(h) {
		const {type: form_type} = this.$props
		const { $slots: {help} } = this
		const props = {
			class: form_type === 'textarea' ? ['textarea'] : ['input'],
			attrs: this.$props,
			on: {
				keyup: (event) => this.$emit('input', event.target.value),
				change: (event) => {
					this.$emit('input', event.target.value)
					this.$emit('change', event)
				}
			},
			ref: 'input',
		}
		return h('div', {class: 'field'}, [
			h('label', {domProps: {innerHTML: this.$props.label }}),
			h(form_type === 'textarea' ? 'textarea' : 'input', props),
			help
		])
	},
}
</script>