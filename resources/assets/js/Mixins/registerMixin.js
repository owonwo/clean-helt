import { validationMixin } from 'vuelidate'
import vHelper from '@/components/vHelper'

export default {
  mixins: [validationMixin],
  components: { vHelper },
  data: () => ({
    page: 0,
    isLoading: false,
    fields: {}
  }),
  notifOptions: {
    group: 'register',
    duration: 2000
  },
  methods: {
    visit_login() {
      window.location = '/login'
    },
    modelIs(model = 'PATIENT') {
      console.assert(Object.keys(this.providerMap).includes(model), 'The Model provided is invalid!')
      return this.$props.model === model
    },
    showEmailMessage() {
      this.page += 1
    },
    handleError(err) {
      const { notifOptions } = this.$options
      if (err.response.status === 422) {
        /*form errors*/
        this.logErrors(err.response.data.errors, notifOptions)
        this.error_message('Some fields need attention.', notifOptions)
      } else if (err.response.status === 403) {
        /*server rejection request*/
        notifOptions.duration = 5000
        this.info_message(`Am sorry, We can't create an 
          account at the moment, please try again later.`, notifOptions)
      }
    },
    /** passes only the validation has no error
     * @returns boolean
     **/
    canSend() {
      return true
    },
    getFormData() {
      const fields = Object.assign({}, this.fields)

      return fields
    },
    toggleLoader() {
      this.isLoading = !this.isLoading
    },
    submit() {
      const { canSend, showEmailMessage, handleError } = this

      if (canSend()) {
        this.toggleLoader()
        this.$http.post(this.url, this.getFormData())
          .then(showEmailMessage)
          .then(this.toggleLoader)
          .then(() => this.$emit('success'))
          .catch(handleError)
          .then(this.toggleLoader)
      } else {
        this.info_message('Some fields are missing!', { group: 'register' })
      }
    }
  }
}