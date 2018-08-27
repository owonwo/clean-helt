<template>
	<section class="">
		<div class="level">
			<div class="card osq-profile-card level">
				<img  class="avatar" :src="$root.avatar" alt="">
				<div class="card-content">
					<div class="osq-text-center">
						<h4 class="profile-title">Kelvin Morrison</h4>
						<p class="mb-35 "></p>
						<div class="buttons is-right">
							<router-link to="/settings" tag="button" class="button is-outlined is-primary is-rounded is-pulled-right">View Profile</router-link>
						</div>
					</div>
				</div>
			</div>
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
                <h2 class="subtitle is-6">FIND SERVICE PROVIDER</h2>
				<div class="card is-green">
					<div class="card-content p-20">
						<div class="field mb-0 has-addons-right">
							<p class="control has-icons-right">
								<input type="text" class="input is-rounded" placeholder="CH-309YU">
								<span class="is-right icon"><i class="osf osf-search"></i></span>
							</p>
						</div>
					</div>
				</div>
			</section>
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
