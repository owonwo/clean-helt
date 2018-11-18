<template>
    <div id="profile-grid">
        <aside>
            <img :src="avatar" class="avatar has-shadow">
            <p class="subtitle is-4 my-10">{{ name }}</p>
            <div class="has-text-centered mt-5 is-fullwidth">
                <label for="change-avatar" class="button is-primary is-rounded">
                    change photo <i class="ml-5 ti ti-pencil"></i>
                </label>
                <input type="file" @change="changeAvatar($event)" id="change-avatar" />
            </div>
        </aside>
        <nav class="osq-profile-nav osq-sidenav">
            <v-scrollbar class="menu">
                <ul v-pager-controls.prevent="{activeClass: 'active'}" class="menu-list">
                    <slot name="navigation"></slot>
                </ul>
            </v-scrollbar>
        </nav>
        <section class="osq-profile-section">
            <slot :page="page"></slot>
        </section>
    </div>
</template>
<script>

export default {
    props: {
    	avatarUrl: { type: String, required: true, default: ""},
        avatar: { type: String, default: '', required: true, },
        name: { type: String, default: '', required: true, },
    },
    data() {
        return {
            page: 0,
        }
    },
    methods: {
    	changeAvatar(evt) {
            const file = evt.target.files[0];
            const form =  new FormData('name');
            form.append('avatar', file);

            this.updateAvatar(form);
        },
        updateAvatar(form = new FormData()) {
            let {avatarUrl} = this.$props;
            0 < avatarUrl.length ?
            this.$http.post(avatarUrl, form).then((res) => {
                this.$store.commit('set_avatar', res.data.path);
            }).catch(err => {
                this.$notify({type:'error', text: err.response.data.message, duration: 2500});
            }) : console.warn('Unspecified Avatar Upload URI.');
        },
    }
}
</script>
