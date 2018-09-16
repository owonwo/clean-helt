<template>
	<section id="hospital">
		<section class="content-top-bar">
			<h3>DASHBOARD</h3>
		</section>
		<div id="osq-hospital-dashboard">
			<section>
				<h3 class="menu-label">New</h3>
				<!-- pending clients -->
				<accordion v-if="$parent.pendingUsers.length > 0">
					<template slot="heading">
						<i class="tag is-primary p-5 mr-15">{{ $parent.pendingUsers.length }}</i> New Clients Shared their Medical Records						
					</template>
					<template slot="content">
						<section class="menu content pl-10 pr-10">
							<div class="py-5" v-for="(profile, index) in $parent.pendingUsers" :key="index">
								<button @click="$parent.acceptShare(profile.id)" class="button is-outlined is-pulled-right is-rounded is-primary">Accept</button>
								<h4 class="title is-5 mb-0">{{ profile.patient.first_name }} {{ profile.patient.last_name }}</h4>
								<span>Access expired {{ profile.expired_at | moment("from") }}</span>
							</div>
						</section>
					</template>
				</accordion>

				<!-- recently viewed clients -->
				<h3 class="menu-label">Recent Views</h3>
				<div class="card card-content">
					
				</div>
			</section>
			<aside id="statistics">
				<h3 class="menu-label">Statistics</h3>
				<div class="card">
					<div class="card-content">
						<h6 class="subtitle is-6 has-text-grey-light">This Week</h6>
						<h4 class="title is-5">Clients <small class="is-pulled-right">{{ $store.state.sharedProfiles.length }}</small></h4>
						<!-- <div class="progress mb-3"></div> -->
						<h4 class="title is-5">Updates <small class="is-pulled-right">10</small></h4>
						<!-- <div class="progress"></div>						 -->
						<h4 class="title is-5">Pending <small class="is-pulled-right">{{ $parent.pendingUsers.length }}</small></h4>
						<!-- <div class="progress"></div>						 -->
					</div>
				</div>
			</aside>
		</div>
	</section>
</template>

<script>
export default {
	name: 'HospitalDashboard',
	data() {return {
	}},
	computed: {
		pendingUsers() {
			return this.$parent.pendingUsers.map((e) => e.patient); 
		}
	}
}	
</script>
