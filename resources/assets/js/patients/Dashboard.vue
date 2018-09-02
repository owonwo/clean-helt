<template>
	<section class="">
		<div class="columns">
			<section class="column">
				<ProfileBox>
					<h4 class="profile-title">Kelvin Morrison</h4>
					<p class="mb-35"></p>
					<div class="has-text-centered">
						<router-link to="/settings" tag="button" class="button is-outlined is-primary is-rounded">View Profile</router-link>
					</div>
				</ProfileBox>
			</section>

			<section class="column">
				<AddServiceProvider class="is-green"/>
			</section>
		</div>

		<h3 class="subtitle is-6">HEALTH SERVICE PROVIDER</h3>
		<div class="columns">
			<div class="column">
				<div class="card card-content">
					<div class="osf osf-hospital"></div>
					<span>
						Hospital						
					</span>
				</div>
			</div>
			<div class="column">
				<div class="card card-content">
					<div class="osf osf-doctor"></div>
					<span>Doctor</span>
				</div>
			</div>
			<div class="column">
				<div class="card card-content">
					<div class="osf osf-pharmacy"></div>
					<span>Pharmacy</span>
				</div>
			</div>
			<div class="column">
				<div class="card card-content">
					<div class="osf osf-lab"></div>
					<span>Laboratory</span>
				</div>
			</div>
		</div>
		<div class="columns">
			<section class="column">
				<h2 class="subtitle is-6">ACTIVITY LOGS</h2>
				<div class="card card-content">
					BOOKMARKS
				</div>
				<div class="card mt-10 card-content">
					SHARED RECORD HISTORY
				</div>
			</section>
		</div>
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'

export default {
	components: {Modal},
	name: 'Dashboard',
	mounted: () => { document.title = "Client Dashboard | Clean Helt" },
	data() {return {
	}},
}
</script>
