<template>
  <section>
    <section class="level level-right">
      <HoverRevealButton
        @click="modal.add_child = true">
        <i 
          slot="icon" 
          class="ti ti-plus"/>
        <span slot="text">ADD CHILD</span>
      </HoverRevealButton>
    </section>
    <div 
      v-if="children.length" 
      class="menu-label">ALL CHILDREN</div>
    <!-- If you have no child you can create one here. -->
    <section class="osq-grid-patients">
      <ProfileBox 
        v-for="(child, index) in children"  
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
          <button 
            class="button is-rounded is-small" 
            @click="unlink(child.id)">
            <i class="ti ti-link"/> Unlink
          </button>
        </div>
      </ProfileBox>
    </section>

    <modal 
      ref="modal"
      :show="modal.add_child"
      size="sm"
      @closed="modal.add_child = false">
      <section>
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

<script>
import { mapState, mapActions } from 'vuex'
import Modal from '@/components/Modal.vue'

export default {
  components: { Modal },
  data() {return {
    submitting: false,
    modal: {
      add_child: false
    },
    form : { email: '', password: '', first_name: '', last_name: '', phone: '' },
  }},
  computed: {
    ...mapState('patient_share', ['children']),
  },
  mounted() {
    this.FETCH_CHILDREN()
  },
  methods: {
    unlink(id) {
      if (id)
      this.$confirm('Are you sure?', 'Once the child account is unlinked, there is no rollback.')
        .then(() => {
          this.unlinkChild(id)
          .then(message => {
            this.success_message(message)
          })
          .catch((e) => {
            this.error_message(e.message)
            setTimeout(() => {
              this.error_message('Please Try again later!')
            }, 300)
          })
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