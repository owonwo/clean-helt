export default {
  data: () => ({
    sidebars: { nav: false, notif: true },
  }),
  mounted() {
    this.toggleSidebar()
  },
  methods: {
    toggleNotification() {
      this.sidebars.notif = !this.sidebars.notif
    },
    toggleSidebar() {
      if (window.innerWidth < 768) {
        this.sidebars.nav = !this.sidebars.nav
      }
    },
    handleAutoCollapse() {
      this.toggleSidebar()
    }
  }
}