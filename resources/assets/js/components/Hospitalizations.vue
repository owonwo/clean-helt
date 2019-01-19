<template>
  <section>
    <div class="level">
      <div class="">
        <alert 
          v-if="!hospitalizations.length" 
          class="mb-0" 
          type="info">
          No Hospitalization Record.
        </alert>
      </div>
      <HoverRevealButton 
        v-if="canEdit"
        @click="$refs.modal.showSelf()">
        <span 
          slot="icon" 
          class="ti ti-plus"/>
        <span slot="text">Add</span>
      </HoverRevealButton>
    </div>

    <div 
      v-for="(entry) in hospitalizations" 
      :key="entry.id" 
      class="mb-20">
      <h1 class="title mb-5 is-5">{{ entry.hospitalization_type }}</h1>
      <p>Doctor: {{ entry.doctor }}</p>
      <p>Hospital: {{ entry.hospital }}</p>
      <p>Reason: {{ entry.reason }}</p>
      <p>Complications: {{ entry.complications }}</p>
    </div>

    <modal 
      ref="modal"
      :show="opened"
      @closed="opened = false">
      <template 
        slot="modal-header" 
        class="title is-4 mb-0">Add Hospitalization
      </template>
      <form @submit.prevent="submit(form)">
        <h6 class="title is-6">Fill the form to add/edit hospitalization.</h6>
        <wgInput
          v-model="form.hospitalization_type" 
          placeholder="Type of Hospitalization"
          type="text"/>
        <wgInput
          v-model="form.doctor"
          type="text"
          placeholder="Name of Doctor"/>
        <wgInput
          v-model="form.hospital"
          type="text"
          placeholder="Name of Hospital"/>
        <wgInput 
          v-model="form.reason" 
          label="Reason for Hospitalization"
          type="textarea"/>
        <wgInput
          v-model="form.complications"
          type="textarea"
          label="Complications of Hospitalization"/>
        <button class="button is-primary">Add</button>
      </form>
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'

export default {
  name: 'Hospitalizations',
  mixins: [CanLock, CrudHelper],
  data: () => ({
    opened: true,
    form: {
      doctor: 'Dr. Micheal Ford',
      hospital: 'First land Hospital',
      complications: 'None',
      reason: 'I got bitten by a mosquito',
      hospitalization_type: 'Headache/Malaria',
    },
    crud: {
      read: {
        action: 'medicalRecord/FETCH_HOSPITALIZATIONS'
      },
      create: {
        action: 'medicalRecord/CREATE_HOSPITALIZATION',
        message: { success: 'Hospitalization added!', error: 'Error adding Hospitalization' }
      },
      update: {
        action: 'medicalRecord/UPDATE_ALLERGY',
        message: { success: 'Hospitalization Update Sucessful', error: 'Error Updating Hospitalization' }
      },
      delete: {
        action: 'medicalRecord/DELETE_ALLERGY',
        message: { success: 'Hospitalization truncated', error: 'Error Deleting Hospitalization' }
      }
    }
  }),
  computed: {
    ...mapState('medicalRecord', ['hospitalizations'])
  },
}
</script>