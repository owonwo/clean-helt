export default {
  data() {
    return { form: {} }
  },
  mounted() {
    this.$store.dispatch(this.crud.read.action)
  },
  methods: {
    validate() {
      return true
    },
    submit(form) {
      this.set_form(form)
      form.id ? this.update() : this.create()
      this.$refs.modal.hide()
    },
    set_form(form) {
      this.form = form
      return this
    },
    clearForm() {
      this.form = {}
    },
    create() {
      const { action, message } = this.crud.create

        !this.validate() ? console.warn('Form validation failed!') :
        this.$store.dispatch(action, this.form)
        .then(() => {
          this.success_message(message.success)
          this.clearForm()
        })
        .catch((errors) => this.logErrors(errors))
    },
    update() {
      const { action, message } = this.crud.update
      this.$store.dispatch(action, this.form)
        .then(() => {
          this.success_message(message.success)
          this.clearForm()
        })
        .catch(errors => this.logErrors(errors))
    },
    trash(id) {
      const { action, message } = this.crud.delete

      this.$store.dispatch(action, id)
        .then(() => this.success_message(message.success))
        .then(() => this.$refs.modal.hide())
    }
  }
}