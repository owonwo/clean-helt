<template>
  <section>
    <div class="level">
      <h1 class="level-left osq-group-subtitle-alt mb-10 pl-10">
        All Clients - <b> {{ sharedProfiles.length }}</b>
      </h1>
      <div class="level-right">
        <div v-if="false">
          Views
          <i class="ti px-15 py-5 ti-layout-grid3"/>
          <i class="ti px-15 py-5 ti-layout-list-thumb"/>
        </div>
        <SearchBox/>
      </div>
    </div>
    <alert
      v-if="sharedProfiles.length < 1"
      class="notification is-info" 
      type="info">You have no client to attend to at the moment.</alert>
    
    <div
      v-for="(profile, key) in sharedProfiles"
      :key="key" 
      class="osq-patient-list">
      <section>
        <div class="counter">{{ key + 1 }}</div>
        <img 
          :src="profile.patient.avatar" 
          class="image">
        <div>
          <h4 class="profile-title">{{ profile.patient.name }}</h4>
          <span class="is-small is-bold menu-label">Share expires {{ profile.expired_at | moment("from", "now") }}</span>
        </div>
      </section>
      <div
        class="has-text-right">
        <button 
          v-if="$store.getters.accountType === 'hospital'"
          class="button is-outlined has-no-motion is-rounded">
          Assign Doctor
        </button>
        <template 
          v-if="$store.getters.accountType === 'doctor'">
          <button 
            class="button is-outlined has-no-motion is-rounded" 
            @click="makeRefer(profile.patient.id)">
            Refer
          </button>
          <router-link 
            :to="{name: 'patient-profile', params: {chcode: profile.patient.chcode, patient_id: profile.patient.id }}" 
            tag="button" 
            class="button has-no-motion is-primary is-rounded">View</router-link>
        </template>
      </div>
    </div>
    </table>
    <modal
      :show="modal"
      size="sm"
      @closed="modal = false">
      <h1 class="title is-4">Refer another Doctor.</h1>
      <p class="mb-10">Pick a doctor to refer this patient to.</p>
      <div class="field">
        <div class="select is-fullwidth">
          <select v-model="refer.doctor">
            <option value="#">Pick a Doctor...</option>
            <option 
              v-for="doctor in doctors" 
              :key="doctor.id" 
              value="doctor.id">{{ doctor }}
            </option>
          </select>
        </div>
      </div>
      <button class="button is-primary">Submit</button>
    </modal>
  </section>
</template>

<script>
import {mapState} from 'vuex'

export default {
  name: 'Patients',
  data(){ return {
    modal: false,
    refer: {
      client: 0,
      doctor: 0,
    }
  }},
  computed: {
    ...mapState('manage_patient', {sharedProfiles: 'patients'}),
    ...mapState('doctor', {doctors: 'fellow_doctors'})
  },
  methods: {
    makeRefer(id) {
      this.refer.client = id
      this.modal = true
    }
  }
}
</script>
