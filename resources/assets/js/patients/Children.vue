<template>
  <section>
    <section class="level level-right">
      <HoverRevealButton
        @click="modal.add_child = true">
        <i class="ti ti-plus" slot="icon"/>
        <span slot="text">ADD CHILD</span>
      </HoverRevealButton>
    </section>
    <div 
      v-if="children.length" 
      class="menu-label">CHILDREN</div>
    <!-- If you have no child you can create one here. -->
    <section class="columns is-wrapped">
      <section 
        v-for="(child, index) in children"  
        class="column is-one-third">
        <ProfileBox 
          :key="index"
          :avatar-src="child.avatar" 
          class="is-portrait is-small is-flat is-rounded">
          <span class="profile-title">
            {{ child.first_name }}
          </span>
          <div class="mt-30">
            <button
              class="button is-primary is-rounded is-small" 
              @click="retrieveToken(child.id)">Access
            </button>
            <button @click="showUnlinkModal(child.id)" class="button ml-10 is-small is-text">
              <i class="ti ti-link"/> Unlink
            </button>
          </div>
        </ProfileBox>
      </section>
    </section>

    <modal 
      ref="modal"
      :show="modal.unlink || modal.add_child"
      size="sm"
      @closed="modal.unlink = modal.add_child = false">
      <section 
        v-if="modal.unlink" 
        class="content is-center">
        <h4 class="is-centered">Are you sure?</h4>
        <p class="is-italic mb-15">Once the child account is unlinked, there is no rollback.</p>
        <div class="buttons is-right">
          <button
            class="button"
            @click="unlink()">Yes</button>
          <button 
            class="button is-success" 
            @click="modal.unlink = false">No</button>
        </div>
      </section>
      <section v-else>
        <h5 class="title is-5 mb-0">Register a Child</h5>
        <p>Fill the form to add a child.</p>
        <form @submit.prevent="submitChildForm(form)">
          <wgInput 
            v-model="form.email" 
            type="email" 
            required=""
            placeholder="Enter Email"/>
          <wgInput 
            v-model="form.first_name" 
            type="text" 
            required
            placeholder="First Name"/>
          <wgInput 
            v-model="form.last_name" 
            type="text" 
            required
            placeholder="Last Name"/>
          <wgInput 
            v-model="form.password" 
            type="text"
            required
            placeholder="Enter Password..."/>
          <wgInput 
            v-model="form.phone" 
            type="text"
            placeholder="Phone Number" />
          <button 
            :class="{'is-loading': submitting}" 
            class="button is-primary">
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
    submitting: false,
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
    showUnlinkModal(child_id) {
      this.selected.id = child_id
      this.modal.unlink = true
    },
    unlink() {
      if (this.selected.id)
      this.unlinkChild(this.selected.id).then(message => {
        this.success_message(message)
        this.$refs.modal.hide()
      }).catch((e) => {
        this.error_message(e.message)
        setTimeout(() => {
          this.error_message('Please Try again later!')
        }, 300)
      })
    },
    submitChildForm() {
      delete this.form.errors
      this.submitting = true

      this.addChild(this.form)
        .then(message => {
          this.form = {}
          this.submitting = false
          this.$refs.modal.hide()
          this.success_message(message)
        })
        .catch(({response: { data }}) => {
          this.submitting = false
          this.logErrors(data.errors)
          this.error_message(data.message)
        })
    },
    ...mapActions('patient_share', ['FETCH_CHILDREN', 'retrieveToken', 'addChild', 'unlinkChild'])
  }
}
</script>