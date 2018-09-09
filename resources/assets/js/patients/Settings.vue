<template>
	<section class="p-15">
		<div class="card card-content is-paddingless">
			<div class="osq-two-columns">
				<aside class="osq-sidenav p-10">
					<div class="menu">
						<div class="menu-label"><i class="ti icon ti-settings" style="font-size: 1.5em;vertical-align: middle;"></i> Settings</div>
						<ul class="menu-list" v-pager-controls.prevent="{activeClass: 'active'}">
							<li v-for="(name, index) in ['Account','Notification', 'Shares']"><a href="#">{{ name }}</a></li>
						</ul>
					</div>
				</aside>

				<section class="content">
					<pager :current="page">
						<div slot="p1" class="p-10">
							<div class="menu-label">Edit Bio</div>
							<table class="table">
								<tr class="">
									<th width="150">Full Name</th>
									<td>Kelvin Morrison</td>
								</tr>
								<tr class="">
									<th>Age</th>
									<td>30</td>
								</tr>
								<tr>
									<th>Email:</th>
									<td>kelvin.morrison@gmail.com</td>
								</tr>
								<tr>
									<th>Gender</th>
									<td>Male</td>
								</tr>
								<tr>
									<th>Address</th>
									<td>1 Khana Street, D/Line, Port Harcourt</td>
								</tr>
								<tr>
									<th>ID</th>
									<td>
										CHD-909-399 
										<button class="button is-small is-text">COPY</button>
									</td>
								</tr>
							</table>
						</div>
						<div slot="p2" class="p-10">
							<toggle-switch size="sm" :value="false"/>
							<span>Notifications</span>
							<p style="font-size: small" class="is-small">I want to receive notifications.</p>
						</div>
					</pager>
				</section>
			</div>
		</div>
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import ToggleSwitch from '@/components/ToggleSwitch.vue'

export default {
	name: 'PatientSettings',
	components: {Modal, ToggleSwitch},
	mounted: () => { document.title = "Settings Dashboard | CleanHelt" },
	data() {return {
		page: 0,
		notification_state: true,
	}},
	methods: {
		setPage(page = 0) {
			this.page = page;
		}
	}
}
</script>
