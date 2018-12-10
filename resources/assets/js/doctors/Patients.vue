<template>
  <section>
    <div class="level">
      <h1 class="level-left osq-group-subtitle-alt mb-10 pl-10">
        All Clients - <b> {{ sharedProfiles.length }}</b>
      </h1>
      <div class="level-right">
        Views
        <i class="ti px-15 py-5 ti-layout-grid3"/>
        <i class="ti px-15 py-5 ti-layout-list-thumb"/> 
      </div>
    </div>
    <alert
      v-if="sharedProfiles.length < 1"
      class="notification is-info" 
      type="info">You have no client to attend to at the moment.</alert>
    <div 
      class="osq-grid-patients">
      <div 
        v-for="(profile, key) in sharedProfiles" 
        :key="key">
        <ProfileBox 
          :avatar-src="profile.patient.avatar" 
          class="is-portrait">
          <section class="osq-text-center">
            <h4 class="profile-title">{{ profile.patient.name }}</h4>
            <p class="mb-30"><small>expires {{ profile.expired_at | moment("from", "now") }}</small></p>
            <div class="buttons is-centered">
              <router-link 
                :to="{name: 'patient-profile', params: {chcode: profile.patient.chcode, patient_id: profile.patient.id }}" 
                tag="button" 
                class="button is-primary is-rounded">View Profile</router-link>
            </div>
          </section>
        </ProfileBox>
      </div>
    </div>
  </section>
</template>

<script>
import {mapState} from 'vuex'

export default {
	name: 'Patients',
	computed: {
		...mapState('manage_patient', {sharedProfiles: 'patients'})
	},
}
</script>
