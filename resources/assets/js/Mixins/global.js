import Vue from 'vue'
import GlobalComponents from '@/components'
import { personalify } from '@/store/helpers/utilities'

Vue.mixin({
	components: {...GlobalComponents},
	methods: {
		testChCode(chcode = '') {
			return RegExp('^CH(P|H|D|L|F)([0-9]{9})$').test(chcode)
		},
		chcodeIs: (prefix, chcode) => chcode.match(RegExp(`^${prefix}`)) !== null,
		personalify(e) {
			const {chcodeIs} = this
			return chcodeIs('CHP', e.chcode) || chcodeIs('CHD', e.chcode) ? personalify(e) : e
		},
		success_message(text) {
			this.$notify({text, type: 'success'})
		},
		error_message(text) {
			this.$notify({text, type: 'error'})
		}
	},
	filters: {
		testChCode(value = '') {
			return this.testChCode(value)
		},
		ucfirst (value) {
			return _.capitalize(value)
		},
		truncate(value, length) {
			return _.truncate(value, {length})
		}
	}
})
