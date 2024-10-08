import Vue from 'vue'
import _ from 'lodash'
import { pipe, compose } from 'lodash/fp'
import GlobalComponents from '@/components'
import { personalify } from '@/store/helpers/utilities'

Vue.mixin({
  components: { ...GlobalComponents },
  filters: {
    testChCode(value = '') {
      return this.testChCode(value)
    },
    ucfirst(value) {
      return _.capitalize(value)
    },
    truncate(value, length) {
      return _.truncate(value, { length })
    }
  },
  methods: {
    pipe,
    compose,
    isDoctor() { return this.$store.getters.accountType === 'doctor' },
    isPatient() { return this.$store.getters.accountType === 'patient' },
    isHospital() { return this.$store.getters.accountType === 'hospital' },
    testChCode(chcode = '') {
      return RegExp('^CH(P|H|D|L|F)([0-9]{9})$').test(chcode)
    },
    chcodeIs: (prefix, chcode) => chcode.match(RegExp(`^${prefix}`)) !== null,
    personalify(e) {
      const { chcodeIs } = this
      return chcodeIs('CHP', e.chcode) || chcodeIs('CHD', e.chcode) ? personalify(e) : e
    },
    success_message(text, options = {}) {
      this.$notify({ ...({ text, type: 'success' }), ...options })
    },
    info_message(text, options = {}) {
      this.$notify({ ...({ text, type: 'info' }), ...options })
    },
    error_message(text, options = {}) {
      this.$notify({ ...({ text, type: 'error' }), ...options })
    },
    make_form_data(data = {}) {
      const form = new FormData()
      for (const [key, value] of Object.entries(data))
        form.append(key, value)
      return form
    },
    getIcon(name) {
      return ['osf osf-'].concat(name.toLowerCase()).join('')
    },
    logErrors(err, options = {}) {
      for (const message of Object.values(err)) {
        message.map(msg => this.error_message(msg, options))
      }
    }
  },
})