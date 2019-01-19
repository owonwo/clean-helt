<template>
  <section>
    <section class="content-top-bar">
      <h3>Dashboard</h3>
    </section>
    <section class="columns">
      <div class="column is-half">
         <h3 class="menu-label">View Profile</h3>
        <ProfileBox 
          :avatar-src="user.avatar" 
          class="is-green mb-30">
          <h4 class="profile-title">Dr. {{ user.first_name }} {{ user.last_name }}</h4>
          <p class="mb-15">{{ user.specialization | ucfirst }}</p>
          <router-link 
            to="/profile" 
            tag="button" 
            class="button is-outlined is-rounded is-white">View Profile</router-link>
        </ProfileBox>
        <h3 class="menu-label">HOSPITALS</h3>
        <accordion :show="true">
          <template slot="heading">
            <i class="tag is-primary p-5 mr-15">{{ hospitals.length }}</i> Active Hospitals
          </template>
          <template slot="content">
            <section class="menu content pl-10 pr-10">
              <div 
                v-for="(hospital, index) in hospitals" 
                :key="index" 
                class="py-5">
                <h4 class="title is-5 mb-0">{{ hospital.name }}</h4>
                <span class="has-text-primary">{{ hospital.chcode }}</span>
              </div>
            </section>
          </template>
        </accordion>
        <accordion
          :show="false">
          <template slot="heading">
            <i class="tag is-primary p-5 mr-15">{{ pendingHospitals.length }}</i> Pending Hospitals                     
          </template>
          <template slot="content">
            <section class="menu content pl-10 pr-10">
              <div 
                v-for="(hospital, index) in pendingHospitals" 
                :key="index" 
                class="py-5">
                <button 
                  class="button is-outlined is-pulled-right is-rounded is-primary" 
                  @click="manageHospital({hospital, action: 'accept'})">Accept</button>
                <h4 class="title is-5 mb-0">{{ hospital.name }}</h4>
                <span class="has-text-primary">{{ hospital.chcode }}</span>
              </div>
            </section>
          </template>
        </accordion>
      </div>
      <div class="column is-half">
        <aside id="statistics">
          <h3 class="menu-label">Statistics</h3>
          <div class="card is-rounded">
            <div class="card-content">
              <h4 class="title is-5">Assigned Clients <small class="is-pulled-right">{{ patients.length }}</small></h4>
              <h4 class="title is-5">Hospitals <small class="is-pulled-right">{{ hospitals.length }}</small></h4>
            </div>
          </div>
        </aside>
      </div>
    </section>
  </section>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex'
import Modal from '@/components/Modal.vue'

export default {
    name: 'Dashboard',
    components: { Modal },
    data() {
        return {}
    },
    computed: {
        ...mapGetters({ user: 'getUser' }),
        ...mapState('doctor', ['pendingHospitals', 'hospitals']),
        ...mapState('manage_patient', ['patients']),
    },
    methods: {
        ...mapActions('doctor', ['manageHospital', 'fetchHospitals']),
        success() {
          this.fetchHospitals()
        }
    }
}
</script>