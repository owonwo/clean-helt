<template>
	<section class="">
		<section class="content-top-bar">
			<h3>Dashboard</h3>
		</section>

		<div class="my-30 columns is-centered">
			<div class="column is-half">
				<h3 class="title is-3 has-text-centered"><span style="font-weight:lighter">SHARE</span>PROFILE</h3>
				<AddServiceProvider class="has-text-centered" model="PATIENT" osq-style="fullwidth"/>
			</div>
		</div>

		<h3 class="subtitle is-6">Health Service Provider</h3>
		<div class="columns">
			<div class="column">
				<div class="card is-service-provider card-content">
					<div class="osf osf-hospital"></div>
					<span>
						Hospital		
					</span>
				</div>
			</div>
			<div class="column">
				<div class="card is-service-provider card-content">
					<div class="osf osf-doctor"></div>
					<span>Doctor</span>
				</div>
			</div>
			<div class="column">
				<div class="card is-service-provider card-content">
					<div class="osf osf-pharmacy"></div>
					<span>Pharmacy</span>
				</div>
			</div>
			<div class="column">
				<div class="card is-service-provider card-content">
					<div class="osf osf-lab"></div>
					<span>Laboratory</span>
				</div>
			</div>
		</div>
		
		<h3 class="subtitle is-6">Activity Log</h3>
		<div>
			<div class="card is-inline-block mr-10 is-green card-content">
				<i class="ti icon ti-bookmark"></i> Bookmarks
			</div>

			<div class="card is-inline-block is-green card-content">
				<i class="ti icon ti-bookmark-alt"></i> Shares History
			</div>
		</div>
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'

export default {
	components: {Modal},
	name: 'Dashboard',
	mounted: () => { document.title = "Client Dashboard | CleanHelt" },
	data() {return {
	}},
}
</script>
