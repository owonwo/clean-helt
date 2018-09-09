<template>
	<section class="">
		<section class="content-top-bar">
			<h3>Dashboard</h3>
		</section>

		<div class="my-30 columns is-centered">
			<div class="column is-half">
				<div class="field has-addons-left">
					<p class="control has-icons-left has-shadow">
						<input type="text" class="input has-text-centered" style="padding-left:calc(0.625em - 1px);border-radius: 30px" placeholder="Find Help by CH-Code">
						<span class="is-left icon"><i class="osf osf-search"></i></span>
					</p>
				</div>
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
