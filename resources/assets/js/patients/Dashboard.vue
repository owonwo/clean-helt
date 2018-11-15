<template>
	<section class="">
		<section class="welcome-banner">
			<hgroup class="has-text-centered">
				<h3 class="title is-5 mb-0">Hello {{user.first_name}}, Welcome Back!</h3>
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
		<div class="columns" style="flex-wrap: wrap">
			<div class="column is-half">
				<div class="card is-service-provider card-content">
					<div class="osf osf-client-alt-green"></div>
					<span>View Medical Record</span>
				</div>
			</div>
			<div class="column is-half">
				<div class="card is-service-provider card-content">
					<div class="osf osf-forum-green"></div>
					<span>Visit CleanHelt Forum</span>
				</div>
			</div>
			<div class="column is-half">
				<div class="card is-service-provider card-content">
					<div class="osf osf-add-green"></div>
					<span>Add Medical Record</span>
				</div>
			</div>
			<div class="column is-half">
				<div class="card is-service-provider card-content">
					<div class="osf osf-search-green"></div>
					<span>Find Medical Centres</span>
				</div>
			</div>
			<div class="column is-half">
				<div class="card is-service-provider card-content">
					<div class="osf osf-hospital-green"></div>
					<span>Share Health Record with Hospital</span>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import {mapGetters} from 'vuex'

export default {
	components: {Modal},
	name: 'Dashboard',
	mounted: () => { document.title = "Client Dashboard | CleanHelt" },
	data() {return {
	}},
	computed: {
		...mapGetters({'user': 'getUser'})
	}
}
</script>
