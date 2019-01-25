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
      if (typeof id !== 'number') throw Error('Invalid argument `id` provided for CrudHelper/trash method')

      const { action, message } = this.crud.delete
      const confirm_message = 'Deleting Record.'
      const text = 'Are you sure you want to delete this record'

      this.$confirm(confirm_message, text)
        .then(() => {
          this.$store.dispatch(action, id)
            .then(() => this.success_message(message.success))
            .then(() => this.$refs.modal.hide())
        })
    }
  }
}