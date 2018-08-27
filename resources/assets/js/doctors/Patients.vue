<template>
	<section>
		<h1 class="osq-group-subtitle-alt mb-10 pl-10">All Clients</h1>
		<div class="osq-grid-patients" style="">
			<div v-for="a in 5" :key="a">
				<div class="card osq-profile-card is-portriat">
					<img  class="avatar" src="$root.avatar" alt="">
					<div class="card-content">
						<div class="osq-text-center">
							<h4 class="profile-title">Mrs. Anita Lucas</h4>
							<p class="mb-30"><small>EXPIRES IN 3 DAYS</small></p>
							<div class="buttons is-centered">
								<router-link tag="button" :to="{name: 'patient-profile', params: {patient_id: 1}}" 
									class="button is-primary is-rounded">View Profile</router-link>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	export default {
		name: "Patients",
		data() {return { 
		}}
	}
</script>
