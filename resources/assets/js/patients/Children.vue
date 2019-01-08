<template>
  <section>
    <br>
    <p class="is-small">
      <button 
        class="button is-small mr-5 is-primary"
        @click="modal.add_child = true">ADD CHILD</button>
      <span>to CleanHelt account.</span>
    </p>
    <div v-if="children.length" class="menu-label">CHILDREN LIST</div>
    <!-- If you have not child you can create one here. -->
    <table 
      v-if="children.length"
      class="table is-fullwidth is-striped is-borderless">
      <thead>
        <tr>
          <th>Names</th>
          <th>Account actions</th>
        </tr>
      </thead>
      <tr 
        v-for="(child, index) in children"
        :key="index">
        <td>{{ child.fullname }}</td>
        <td>
          <button 
            class="button is-small has-no-motion is-primary" 
            @click="retrieveToken(child.id)">Access
          </button>
          <button 
            class="button is-small has-no-motion  is-text" 
            @click="modal.unlink = true">
            <i class="ti ti-link"/> Unlink Child
          </button>
        </td>
      </tr>
    </table>

    <modal 
      :show="modal.unlink || modal.add_child"
      size="sm"
      @closed="modal.add_child = modal.unlink = false">
      <section 
        v-if="modal.unlink" 
        class="content is-center">
        <h4 class="is-centered">Are you sure?</h4>
        <p class="is-italic mb-15">Once the child account is unlinked, there is no rollback.</p>
        <div class="buttons is-right">
          <button
            class="button"
            @click="unlinkChild">Yes</button>
          <button 
            class="button is-success" 
            @click="modal.unlink = false">No</button>
        </div>
      </section>
      <section v-else>
        <h5 class="title is-5 mb-0">Register a Child</h5>
        <p>Fill the form to add a child.</p>
        <form @submit.prevent="submitChildForm(form)">
          <form-input 
            v-model="form.email" 
            type="email" 
            required=""
            placeholder="Enter Email" 
            @value="e => form.email = e" />
          <form-input 
            v-model="form.first_name" 
            type="text" 
            required
            placeholder="First Name" 
            @value="e => form.first_name = e" />
          <form-input 
            v-model="form.last_name" 
            type="text" 
            required
            placeholder="Last Name" 
            @value="e => form.last_name = e"/>
          <form-input 
            v-model="form.password" 
            type="text"
            required
            placeholder="Enter Password..." 
            @value="e => form.password = e"/>
          <form-input 
            v-model="form.phone" 
            type="text"
            placeholder="Phone Number" 
            @value="e => form.phone = e"/>
          <button class="button is-primary">
            <i class="ti icon ti-plus"/>
            <span>Submit</span>
          </button>
        </form>
      </section>
    </modal> 
  </section>
</template>

<style lang="sass" scoped>
table
   tr
      .button
        transition-duration: 0s
        text-decoration: none
        &:last-child
          visibility: hidden
      &:hover 
        .button:last-child
          visibility: visible
</style>

<script>
import { mapState, mapActions } from 'vuex'
import Modal from '@/components/Modal.vue'

export default {
  components: { Modal },
  data() {return {
    modal: {
      unlink: false,
      add_child: false
    },
    form : { email: '', password: '', first_name: '', last_name: '', phone: '' },
    selected: {}
  }},
  computed: {
    ...mapState('patient_share', ['children']),
  },
  mounted() {
    this.FETCH_CHILDREN()
  },
  methods: {
    unlink() {
      if (this.selected.id)
      this.unlinkChild(this.selected.id).then(message => {
        this.success_message(message)
      }).catch((e) => {
        this.error_message(e.message)
        setTimeout(() => {
          this.error_message('Please Try again later!')
        }, 300)
      })
    },
    submitChildForm() {
      delete this.form.errors
      this.addChild(this.form)
        .then(message => {
          this.form = {}
          this.modal.add_child = false
          this.success_message(message)
        })
        .catch(({response: { data }}) => {
          this.form.errors = data.errors
          this.error_message(data.message)
        })
    },
    ...mapActions('patient_share', ['FETCH_CHILDREN', 'retrieveToken', 'addChild', 'unlinkChild'])
  }
}
</script>