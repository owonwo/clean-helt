import Dialog from '@/components/Dialog.vue'

const DialogPlugin = {
  install(Vue) {
    Vue.component(Dialog.name, Dialog)

    Vue.mixin({
      methods: {
        $confirm() {
          return this.$root.$refs.dialog.confirm(...arguments)
        }
      }
    })
  }
}

export default DialogPlugin