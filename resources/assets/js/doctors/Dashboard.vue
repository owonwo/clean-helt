	<template>
		<section class="">
			<div class="level">
				<div class="card osq-profile-card  level is-green">
					<img  class="avatar" :src="$root.avatar" alt="">
					<div class="card-content">
						<div class="osq-text-center">
							<h4 class="profile-title">Joseph Owonvwon</h4>
							<p class="mb-15">Specialist Dermatologist and Vereologist</p>
							<div class="buttons is-right">
								<router-link to="/profile" tag="button" class="button is-text is-pulled-right">View Profile</router-link>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column is-two-thirds">
					<div class="card osq-table">
						<div class="card-header">
							<h1 class="card-header-title">Recently Viewed Patients</h1>						
						</div>
						<div class="card-content p-0">
							<table id="recent-views" class="table middle is-fullwidth">
								<tr>
									<th width="50px">Photo</th>
									<th>Full Name</th>
									<th>Status</th>
								</tr>
								<tr>
									<td><img :src="$root.avatar" class="avatar avatar-50"/></td>
									<td class="">Jonas King</td>
									<td class=""><span class="tag is-info">Active</span></td>
								</tr>
								<tr>
									<td><img :src="$root.avatar" class="avatar avatar-50"/></td>
									<td class="">Richard Kane</td>
									<td class=""><span class="tag is-success">Closed</span></td>
								</tr>
							</table>
						</div>
					</div>		
				</div>
			</div>
		</section>
	</template>

<style scoped="" lang="scss">
	table#recent-views {
		tr > td {
			vertical-align: middle;
		}
	}
</style>
<script>
import Modal from '@/components/Modal.vue'

export default {
	components: {Modal},
	name: 'Dashboard',
	data() {return {
	}},
}
</script>
