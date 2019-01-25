<template>
  <div 
    id="profile-grid"
    :class="{'has-more-space': !showSidebar}" >
    <button 
      class="aside-toggler" 
      @click="showSidebar = !showSidebar">
      <i class="ti ti-layout-sidebar-left icon"/>
    </button>
    <aside>
      <img 
        :src="avatar" 
        class="avatar has-shadow">
      <div 
        v-if="!!$props.avatarUrl"
        class="avatar-upload-holder has-text-centered mt-5 is-fullwidth">
        <label 
          for="change-avatar" 
          class="avatar-upload-btn">
          Change Avatar
        </label>
        <input 
          id="change-avatar" 
          type="file" 
          @change="changeAvatar($event)" >
      </div>
      <p class="name-holder">{{ name }}</p>
    </aside>
    <nav
      class="osq-profile-nav osq-sidenav"
      @click="changePage()">
      <v-scrollbar class="menu">
        <ul 
          v-pager-controls.prevent="{activeClass: 'active'}" 
          class="menu-list">
          <slot name="navigation"/>
        </ul>
      </v-scrollbar>
    </nav>
    <section class="osq-profile-section">
      <slot :page="page"/>
    </section>
  </div>
</template>
<script>

export default {
    props: {
        avatarUrl: { type: String, required: true, default: ''},
        avatar: { type: String, default: '', required: true, },
        name: { type: String, default: '', },
    },
    data() {
        return {
            page: 0,
            showSidebar: true
        }
    },
    methods: {
        changePage() {
            if (window.innerWidth <= 1000) {
                this.showSidebar = !this.showSidebar           
            }
        },
        changeAvatar(evt) {
            const file = evt.target.files[0]
            const form =  new FormData('name')
            form.append('avatar', file)

            this.updateAvatar(form)
        },
        updateAvatar(form = new FormData()) {
            let {avatarUrl} = this.$props
            0 < avatarUrl.length ?
            this.$http.post(avatarUrl, form).then((res) => {
                this.$store.commit('set_avatar', res.data.path)
            }).catch(err => {
                const { avatar } = err.response.data.errors
                if (avatar)
                avatar.forEach(err_msg => this.$notify({
                    type:'error', 
                    text: err_msg, 
                    duration: 5000
                }))
            }) : console.warn('Unspecified Avatar Upload URI.')
        },
    }
}
</script>
