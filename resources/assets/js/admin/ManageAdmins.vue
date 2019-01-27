<template>
  <section id="manage-admins">
    <nav class="content-top-bar">
      <h3>Manage Admins</h3>
    </nav>
    <div class="container">
      <section class="columns" style="max-width: 100%">
        <section class="column">
          <nav class="menu-label">CHADMIN LIST</nav>
          <v-scrollbar style="max-width: 100vw; ">
            <table class="table is-striped is-fullwidth">
              <tbody>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Status</th>
                </tr>
                <tr 
                  v-for="(admin) in admins" 
                  :key="admin.id">
                  <td><i class="ti ti-user"/></td>        
                  <td>{{ admin.name }}</td>
                  <td>{{ admin.email }}</td>
                  <td>{{ admin.roles || '' }}</td>
                  <td 
                    title="Click to toggle status"
                    @click="toggleAdminStatus(admin)"
                    style="cursor: pointer">
                    <span 
                      v-if="admin.active" 
                      class="tag is-success">active</span>
                    <span 
                      v-else 
                      class="tag is-black">disabled</span>
                  </td>           
                </tr>
              </tbody>
            </table>
          </v-scrollbar>
        </section>
        <section class="column is-one-third">
          <nav class="menu-label">CREATE CHADMIN</nav>
          <section class="card">
            <form 
              class="card-content" 
              @submit.prevent="createAdmin">
              <wgInput 
                v-model="form.name" 
                type="text"
                placeholder="James Doe"/>
              <wgInput
                v-model="form.email" 
                type="email"
                placeholder="someone@cleanhelt.org"/>
              <wgInput 
                v-model="form.password" 
                type="password"
                placeholder="Password..."/>
              <transition name="fade">
                <wgInput
                  v-show="!form.passsword && (form.password.length > 5)"
                  v-model="form.password_confirmation" 
                  type="password"
                  placeholder="Confirm Password..."/>
              </transition>
              <button class="button is-primary">
                Create
              </button>
            </form>
          </section>
        </section>
      </section>
    </div>
  </section>
</template>

<script>
import axios from 'axios'

const adminURI = ({
  base: '/api/admin/admins',
  adminToggleStatus(active, id) {
    return active 
    ? `/api/admin/admins/${id}/disable` 
    : `/api/admin/admins/${id}/enable`
  }
})

  export default {
    name: 'ManageAdmins',
    data() {return {
      admins: [],
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }},
    computed: {
    },
    created() {
      this.fetchAdmins()
    },
    methods: {
      fetchAdmins() {
        axios.get(adminURI.base)
          .then(res => res.data)
          .then(data => this.admins = data)
          .catch(err => console.log('Fetching Failed', err))
      },
      toggleAdminStatus({active, id}) {
        const url = adminURI.adminToggleStatus(active, id)

        axios.patch(url)
          .then(({data}) => this.success_message(data.message))
          .then(() => this.fetchAdmins())
          .catch(({ response: {data} }) => this.error_message(data.message))
      },
      createAdmin() {
        axios.post(adminURI.base, this.form)
          .then(({data: {message}}) => this.success_message(message))
          .then(() => this.form = {password: ''})
          .then(() => this.fetchAdmins())
          .catch((err) => this.error_message(err.response.data.message))
      }
    }
  }
</script>