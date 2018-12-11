<template>
  <section>
    <div class="level">
      <h1 class="level-left osq-group-subtitle-alt mb-10 pl-10">
        All Clients - <b> {{ sharedProfiles.length }}</b>
      </h1>
      <div class="level-right">
        <div>
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
    <table 
      class="table is-hovered is-fullwidth">
      <tr
        v-for="(profile, key) in sharedProfiles"
        :key="key" 
        class="osq-patient-list">
        <td width="30px">{{ key + 1 }}</td>
        <td width="">
          <img 
            :src="profile.patient.avatar" 
            class="image">
        </td>
        <td>
          <h4 class="profile-title">{{ profile.patient.name }}</h4>
        </td>
        <td width="200px">
          <i>expires {{ profile.expired_at | moment("from", "now") }}</i>
        </td>
        <td 
          width="200" 
          class="has-text-right">
          <router-link 
            :to="{name: 'patient-profile', params: {chcode: profile.patient.chcode, patient_id: profile.patient.id }}" 
            tag="button" 
            class="button is-primary is-rounded">View Profile</router-link>
        </routere-link></td>
      </tr>
    </table>
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
