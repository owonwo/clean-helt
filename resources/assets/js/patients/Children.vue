<template>
  <section>
    <br>
    <p class="has-text-weight-bold">You can manage your children accounts from here</p>
    <!-- If you have not child you can create one here. -->
    <table class="table is-borderless">
      <thead>
        <tr>
          <th>Children</th>
          <th>Actions</th>
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
            @click="modal = true">
            <i class="ti ti-link"/> Unlink Child
          </button>
        </td>
      </tr>
    </table>

    <modal 
      :show="modal"
      size="sm"
      @closed="modal = false">
      <div class="content is-center">
        <h4 class="is-centered">Are you sure?</h4>
        <p class="is-italic mb-15">Once the child account is unlinked, there is no rollback.</p>
        <div class="buttons is-right">
          <button
            class="button"
            @click="unlinkChild">Yes</button>
          <button 
            class="button is-success" 
            @click="modal = false">No</button>
        </div>
      </div>
    </modal> 
  </section>
</template>

<style lang="sass" scoped>
table
   tr
      .button
        visibility: hidden
        transition-duration: 0s
        text-decoration: none

      &:hover 
        .button 
          visibility: visible
</style>

<script>
import { mapState, mapActions } from 'vuex'
import Modal from '@/components/Modal.vue'

export default {
  components: { Modal },
  data() {return {
    modal: false,
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
    ...mapActions('patient_share', ['FETCH_CHILDREN', 'retrieveToken', 'unlinkChild'])
  }
}
</script>