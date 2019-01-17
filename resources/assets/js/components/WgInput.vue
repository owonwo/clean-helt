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
				input.value = (a || '')
			} 
		}
	},
	render(h) {
		const {type: input_type} = this.$props
		const { 
			$slots: {help, default: default_slot}, 
			$props, $attrs
		} = this

		const props = {
			class: input_type === 'textarea' ? ['textarea'] : ['input'],
			attrs: {...$props,...$attrs},	
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
			h(input_type === 'textarea' ? 'textarea' : 'input', props),
			help, default_slot
		])
	},
}
</script>