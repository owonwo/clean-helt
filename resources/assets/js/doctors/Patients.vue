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
        <SearchBox 
          placeholder="Find Patient"
          @value="e => search_string = e"/>
      </div>
    </div>
    <alert
      v-if="sharedProfiles.length < 1"
      class="notification is-info" 
      type="info">You have no client to attend to at the moment.</alert>
    
    <div
      v-for="(profile, key) in filtered"
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
            @click="makeRefer(profile.share.id)">
            Refer
          </button>
          <router-link 
            :to="{name: 'patient-profile', params: {chcode: profile.patient.chcode, patient_id: profile.patient.id }}" 
            tag="button" 
            class="button has-no-motion is-primary is-rounded">View</router-link>
        </template>
      </div>
    </div>
    <modal
      ref="modal"
      :show="modal"
      size="sm"
      @closed="modal = false">
      <ReferDoctor
        :share-id="refer.share"/>
    </modal>
  </section>
</template>

<script>
import {mapState} from 'vuex'
import ReferDoctor from '@/doctors/ReferDoctor'

export default {
  name: 'Patients',
  components: { ReferDoctor },
  data(){ return {
    modal: false,
    search_string: '',
    refer: {
      share: 0,
    }
  }},
  computed: {
    ...mapState('manage_patient', {sharedProfiles: 'patients'}),
    ...mapState('doctor', {doctors: 'fellow_doctors'}),
    filtered() {
      return this.sharedProfiles.filter(e => e.patient.first_name.toLowerCase().includes(this.search_string.toLowerCase()))
    }
  },
  methods: {
    makeRefer(id) {
      this.refer.share = id
      this.$refs.modal.hide()
    }
  }
}
</script>
