<template>
	<section>
		<h1 class="osq-group-subtitle-alt mb-10 pl-10">
			All Clients - <b> {{ sharedProfiles.length }}</b>
		</h1>
		<div v-if="sharedProfiles.length < 1" class="notification is-info">You have no client to attend to at the moment.</div>
		<div class="osq-grid-patients" style="">
			<div v-for="(profile, key) in sharedProfiles" :key="key">
				<div class="card osq-profile-card is-portriat">
					<img  class="avatar" :src="profile.patient.avatar">
					<div class="card-content">
						<div class="osq-text-center">
							<h4 class="profile-title">{{ profile.patient.first_name }} {{ profile.patient.last_name }}</h4>
							<p class="mb-30"><small>expires {{ profile.expired_at | moment("from", "now") }}</small></p>
							<div class="buttons is-centered">
								<router-link tag="button" :to="{name: 'patient-profile', params: {patient_id: profile.patient.id }}" 
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
	import {mapState} from 'vuex';

	export default {
		name: "Patients",
		computed: {
			...mapState(['sharedProfiles'])
		}
	}
</script>
