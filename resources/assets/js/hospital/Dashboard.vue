<template>
  <section class="is-fullwidth">
    <section class="content-top-bar">
      <h3>Dashboard</h3>
    </section>
    <div id="osq-hospital-dashboard">
      <section>
        <h3 class="menu-label">New</h3>
        <!-- pending clients -->
        <accordion>
          <template slot="heading">
            <i class="tag is-primary p-5 mr-15">{{ pendingPatients.length }}</i> New Clients Shared their Medical Records						
          </template>
          <template slot="content">
            <section class="menu content pl-10 pr-10">
              <div 
                v-for="(profile, index) in pendingPatients" 
                :key="index" 
                class="py-5">
                <button 
                  class="button is-outlined is-pulled-right is-rounded is-primary" 
                  @click="ACCEPT_SHARE(profile.id)">Accept</button>
                <h4 class="title is-5 mb-0">{{ profile.patient.first_name }} {{ profile.patient.last_name }}</h4>
                <span>Access expires {{ profile.expired_at | moment("from") }}</span>
              </div>
            </section>
          </template>
        </accordion>
      </section>
      <aside id="statistics">
        <h3 class="menu-label">Statistics</h3>
        <div class="card is-rounded">
          <div class="card-content">
            <h6 class="subtitle is-6 has-text-grey-light">This Week</h6>
            <h4 class="title is-5">Clients <small class="is-pulled-right">{{ patients.length }}</small></h4>
            <!-- <div class="progress"></div>						 -->
            <h4 class="title is-5">Pending <small class="is-pulled-right">{{ pendingPatients.length }}</small></h4>
            <!-- <div class="progress"></div>						 -->
          </div>
        </div>
      </aside>
    </div>
  </section>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
	name: 'HospitalDashboard',
	data() {return {
	}},
	computed: {
		...mapState('manage_patient', ['pendingPatients', 'patients'])
	},
	methods: {
		...mapActions(['ACCEPT_SHARE'])
	}
}	
</script>
