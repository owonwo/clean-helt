<template>
  <section class="">
    <section class="welcome-banner">
      <hgroup class="has-text-centered">
        <h3 class="title is-5 mb-0">Hello {{ user.first_name }}, Welcome Back!</h3>
        <h6>What will you like to do today?</h6>
      </hgroup>
    </section>
    <!---
		<div class="my-30 columns is-centered">
			<div class="column is-half">
				<h3 class="title is-3 has-text-centered"><span style="font-weight:lighter">SHARE</span>PROFILE</h3>
				<AddServiceProvider class="has-text-centered" model="PATIENT" osq-style="fullwidth"/>
			</div>
		</div>
		-->
    <div 
      class="columns" 
      style="flex-wrap: wrap">
      <div class="column is-half">
        <router-link 
          tag="div" 
          to="/profile#log" 
          class="card is-service-provider card-content pointed">
          <div class="osf osf-client-alt-green"/>
          <span>View Medical Record</span>
        </router-link>
      </div>
      <div class="column is-half">
        <div class="card is-service-provider card-content pointed">
          <div class="osf osf-forum-green"/>
          <span>Visit CleanHelt Forum</span>
        </div>
      </div>
      <div class="column is-half">
        <router-link 
          to="/profile#family" 
          tag="div" 
          class="card is-service-provider card-content pointed">
          <div class="osf osf-add-green"/>
          <span>Add Medical Record</span>
        </router-link>
      </div>
      <div class="column is-half">
        <router-link 
          to="/services" 
          tag="div" 
          class="card is-service-provider card-content pointed">
          <div class="osf osf-search-green"/>
          <span>Find Medical Centres</span>
        </router-link>
      </div>
      <div class="column is-half">
        <router-link 
          to="/profile-shares"
          tag="div" 
          class="card is-service-provider card-content pointed">
          <div class="osf osf-hospital-green"/>
          <span>Share Health Record with Hospital</span>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import {mapGetters} from 'vuex'

export default {
	name: 'Dashboard',
	components: {Modal},
	data() {return {
	}},
	computed: {
		...mapGetters({'user': 'getUser'})
	},
	mounted: () => { document.title = 'Client Dashboard | CleanHelt' },
}
</script>
