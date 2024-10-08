<template>
  <section>
    <div class="content-top-bar level">
      <h3>
        Manage Clients 
      </h3>

      <SearchBox 
        v-model="search_string"
        placeholder="Find Patient"/>

      <div class="level-right">
        <span class="osq-group-subtitle-alt">
          {{ sharedProfiles.length }} Client(s) Available
        </span>
        <div v-if="false">
          Views
          <i class="ti px-15 py-5 ti-layout-grid3"/>
          <i class="ti px-15 py-5 ti-layout-list-thumb"/>
        </div>
      </div>
    </div>

    <alert
      v-if="sharedProfiles.length < 1"
      class="notification is-info" 
      type="info">You have no client to attend to at the moment.</alert>

    <template v-if="isHospital()">
      <h4 class="menu-label">Unassigned Clients</h4>
      <PatientList
        v-for="(profile) in unassigned"
        :profile="profile"
        :key="profile.id"
        @click="handleClick"/>
      <br>
      <h4 class="menu-label">Assigned Clients</h4>
      <PatientList 
        v-for="(profile) in assigned"
        :profile="profile"
        :key="profile.id"
        @click="handleClick"/>
    </template>

    <PatientList
      v-for="(profile, key) in filtered"
      v-else
      :profile="profile"
      :key="key"/>

    <modal
      ref="modal"
      :show="modal"
      @closed="modal = false">
      <AssignPatient
        v-if="isHospital()"
        :patient-share-id="share_id"
        @success="$refs.modal.hide()"/>
      <ReferDoctor
        v-if="isDoctor()"
        :share-id="refer.share"/>
    </modal>
  </section>
</template>

<script>
import {mapState} from 'vuex'
import ReferDoctor from '@/doctors/ReferDoctor'
import PatientList from '@/doctors/PatientList'
import AssignPatient from '@/hospital/AssignPatient'

export default {
  name: 'Patients', 
  components: { AssignPatient, ReferDoctor, PatientList },
  data(){ return {
    modal: false,
    search_string: '',
    share_id: 0,
    refer: {
      share: 0,
    }
  }},
  computed: {
    ...mapState('manage_patient', {sharedProfiles: 'patients'}),
    ...mapState('doctor', {doctors: 'fellow_doctors'}),
    filtered() {
      const {searchMatch} = this
      return this.sharedProfiles.filter(searchMatch)
    },
    unassigned() {
      return this.filtered.filter(this.isShared).sort(this.isShared)
    },
    assigned() {
      return this.filtered.filter(e => !this.isShared(e)).sort(this.isShared)
    }
  },
  mounted() {
    if (this.isDoctor()) 
      this.$store.dispatch('manage_patient/FETCH_ALL_PATIENTS', 'doctor')
  },
  methods: {
    isShared: (profile) => !profile.extensions.length,
    makeRefer(id) {
      this.refer.share = id
      this.modal = true
    },
    handleClick(payload) {
      switch(payload.action) {
        case 'assign':
          this.showAssignModal(payload.profile_share_id)
          break
      }
    },
    showAssignModal(share_id) {
      this.share_id = share_id
      this.modal = true
    },
    searchMatch(e) {
      return e.patient.first_name.toLowerCase().includes(this.search_string.toLowerCase())
    }
  }
}
</script>
