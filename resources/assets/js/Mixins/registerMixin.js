import { validationMixin } from 'vuelidate'
import vHelper from '@/components/vHelper'

export default {
  mixins: [validationMixin],
  components: { vHelper },
  data: () => ({
    page: 0,
    fields: {}
  }),
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
      this.fields = {}
    },
    handleError(err) {
      if (err.response.status === 422) {
        /*form errors*/
        this.errors = err.response.data.errors
        this.error_message('Some fields need attention.', { group: 'register', duration: 2000 })
      } else if (err.response.status === 403) {
        /*server rejection request*/
        this.info_message(`Am sorry, We can't create an 
          account at the moment, please try again later.`, { group: 'register', duration: 5000 })
      }
    },
    canSend() {
      return true
    },
    getFormData() {
      const fields = Object.assign({}, this.fields)

      return fields
    },
    submit() {
      this.errors = {}
      const { canSend, showEmailMessage, handleError } = this

      if (canSend()) {
        this.$http.post(this.url, this.getFormData())
          .then(showEmailMessage)
          .catch(handleError)
      } else {
        this.info_message('Some fields are missing!', { group: 'register' })
      }
    }
  }
}