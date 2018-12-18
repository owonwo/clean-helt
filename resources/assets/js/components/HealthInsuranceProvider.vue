<template>
  <section>
    <section class="level">
      <HoverRevealButton 
        v-if="canEdit"
        class="is-pulled-right" 
        @click="opened = !opened">
        <i 
          slot="icon" 
          :class="{'ti-plus': !opened, 'ti-minus': opened}" 
          class="ti"/>
        <span slot="text">{{ !opened ? 'Add' : 'Close' }}</span>
      </HoverRevealButton>
    </section>
    <form 
      v-if="opened && canEdit"
      method="POST"
      class="mb-15" 
      @submit.prevent="submit">
      <span class="title is-6 mb-0">CREATE INSURANCE PROVIDER</span>
      <div class="field">
        <div class="field-body">
          <div class="field">
            <input 
              v-model="form.company_name" 
              type="text" 
              placeholder="Company Name" 
              class="input">
          </div>
          <div class="field">
            <input 
              v-model="form.insurance_type" 
              type="text" 
              placeholder="Insurance Type" 
              class="input">
          </div>
        </div>
      </div>
      <div class="field is-horizontal">
        <div class="field-body">
          <div class="field">
            <input 
              v-model="form.phone" 
              type="text" 
              placeholder="Phone Number" 
              class="input">
          </div>
          <div class="field">
            <input 
              v-model="form.emergency_phone" 
              type="text" 
              placeholder="Emergency Phone Number" 
              class="input">
          </div>
          <div class="field">
            <input 
              v-model="form.city" 
              type="text" 
              placeholder="City" 
              class="input">
          </div>
        </div>
      </div>
      <div class="field">
        <textarea 
          v-model="form.address" 
          class="textarea" 
          placeholder="Address"/>
      </div>
      <div class="field">
        <button 
          type="submit" 
          class="button is-primary">
          Create
        </button>
      </div>
    </form>
    <table 
      v-for="(entry, index) in insurances" 
      :key="index"
      class="table is-fullwidth">
      <tr>
        <td colspan="2">
          <span class="title is-5">{{ entry.company_name }}
          </span>
          <HoverRevealButton 
            v-if="canEdit"
            class="is-pulled-right"
            @click="$store.dispatch('health_insurance/DELETE', entry)">
            <i
              slot="icon" 
              class="ti ti-trash"/>
            <span slot="text">Delete</span>
          </HoverRevealButton>
        </td>
      </tr>
      <tr>
        <td>Insurance Provider Type</td>
        <td>{{ entry.insurance_type }}</td>
      </tr>
      <tr>
        <td>Company Name</td>
        <td>{{ entry.company_name }}</td>
      </tr>
      <tr>
        <td>Address</td>
        <td>{{ entry.address }}</td>
      </tr>
      <tr>
        <td>City</td>
        <td>{{ entry.city }}</td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>{{ entry.phone }}</td>
      </tr>
      <tr>
        <td>Emergency Phone</td>
        <td>{{ entry.emergency_phone }}</td>
      </tr>
    </table>
  </section>
</template>

<style lang="scss" scoped>
.table {
	background-color: white;
	border: solid 2px #ddd;
}
</style>

<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'

export default {
	name: 'HealthInsurance',
  mixins: [CanLock],
	data() {return {
		form: {},
		opened: false
	}},
	computed: {
		...mapState('health_insurance', {
			insurances: (store) => store.insurances
		})
	},
	mounted() {
		this.$store.dispatch('health_insurance/FETCH')
	},
	methods: {
		submit() {
			this.$store.dispatch('health_insurance/CREATE', this.form).then(() => {
				this.opened = false
				this.$notify({text: 'Insurance provider created', type: 'success'})
			}).catch(() => {
				this.$notify({text: 'Error creating insurance provider', type: 'error'})
			})
		}
	}
}
</script>