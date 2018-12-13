<template>
  <section>
    <p class="notification is-info is-small">You can manage your children accounts from here</p>
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
            @click="unlink(child.id)">
            <i class="ti ti-link"/> Unlink Child
          </button>
        </td>
      </tr>
    </table>
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

export default {
	data() {return {
	}},
	computed: {
		...mapState('patient_share', ['children']),
	},
	mounted() {
		this.FETCH_CHILDREN()
	},
	methods: {
    unlink(id) {
      this.unlinkChild(id).then(message => {
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