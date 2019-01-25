<template>
  <section>
    <section class="level">
      <div>
        <alert 
          v-if="insurances.length < 1" 
          type="info">
          No Health Insurance present.
        </alert>
      </div>
      <HoverRevealButton 
        v-if="canEdit" 
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
    <section
      v-for="(entry, index) in insurances" 
      :key="index"
      class="insurance-card">
      <div class="level">
        <div>
          {{ entry.company_name }} 
          <span class="under-label">Company Name</span>
        </div>
        <div>
          {{ entry.insurance_type }}
          <span class="under-label">Insurance Provider Type</span>
        </div>
        <div class="actions-btn">
          <HoverRevealButton 
            v-if="canEdit"
            icon="ti ti-trash"
            text="Delete"
            class="is-pulled-right" 
            @click="trash(entry.id)"/>
        </div>
      </div>
      <div class="level">
        <div>
          <div class="mb-10">
            {{ entry.phone }}
            <span class="under-label">Phone</span>
          </div>
          <div>
            {{ entry.emergency_phone }}
            <span class="under-label">Emergency Phone</span>
          </div>
        </div>
        <div>
          {{ entry.address }}
          <span class="under-label">Address</span>
        </div>
        <div>
          {{ entry.city }}
          <span class="under-label">City</span>
        </div>
      </div>
    </section>
  </section>
</template>

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
    trash(id) {
      this.$confirm('Deleting Health Insurance', 'Please confirm delete.')
        .then(() => {
          this.$store.dispatch('health_insurance/DELETE', id)
        })
    },
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