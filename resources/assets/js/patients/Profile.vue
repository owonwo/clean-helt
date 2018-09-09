<template>
	<section>
		<section class="content-top-bar">
			<h3>Profile</h3>
		</section>
		<div id="profile-grid">
			<aside>
				<img style="height: 100px; width: 100px" src="/images/assets/avatar.jpg" alt=""
					class="avatar has-shadow">
				<p class="subtitle is-5 mb-5 has-text-white">Kelvin Morrison</p>
				<div class="has-text-right" style="width: 100%">
					<button class="button is-primary is-rounded">change photo <i class="ml-5 ti ti-pencil"></i></button>
				</div>
			</aside>
			<nav class="osq-sidenav p-10">
				<div class="menu">
					<ul v-pager-controls.prevent="{activeClass: 'active'}" class="menu-list">
						<li><a href="#">User Profile</a></li>
						<li class=""><a href="#">Pharmacy Dispensing Record</a></li>
						<li class=""><a href="#">Doctor's Diagnosis</a></li>
						<li class=""><a href="#">Lab Record</a></li>
					</ul>
				</div>
			</nav>
			<v-scrollbar>
				<pager :current="page">
					<div slot="p1" class="">
						<div class="menu-label">User Information</div>
						<accordion>
							<template slot="heading">Basic</template>
							<section slot="content">
								<table class="table is-narrow" style="font-size: smaller">
									<tr class="">
										<th width="150">Full Name</th>
										<td>{{ user.full_name }}</td>
									</tr>
									<tr class="">
										<th>Age</th>
										<td>{{ user.age }}</td>
									</tr>
									<tr>
										<th>Email:</th>
										<td>{{ user.email }}</td>
									</tr>
									<tr>
										<th>Gender</th>
										<td>{{user.gender | ucfirst}}</td>
									</tr>
									<tr>
										<th>Address</th>
										<td>{{user.address}}</td>
									</tr>
									<tr>
										<th>ID</th>
										<td>
											{{ user.chcode }} 
											<button class="button is-small is-text">COPY</button>
										</td>
									</tr>
								</table>
							</section>
						</accordion>
						<accordion>
							<template slot="heading">Emergency Hospital</template>
							<section slot="content">
								<h3 class="m-0">EZ Hospitals</h3>
								<b class="m-0">Address:</b>
								<p>NO 35 WHIMPEY JUNCTION, RUMUEME. RIVERS STATE</p>
							</section>
						</accordion>
					    <accordion class="menu">
							<template slot="heading">Next of Kin<!-- Emergency Contact --></template>
							<section slot="content" class="content">
								<h1 class="title is-5 mb-0">Micheal Obiks</h1>
								<div>
									<small>Email Address: mic.obiks@gmail.com</small>
								</div>
								<div>
									<small>Phone Number: 03859300959</small>
								</div>
							</section>
						</accordion>
					</div>
					<div slot="p2">
						<h3 class="menu-label">Dispensing Records</h3>
					</div>
					<div slot="p3" class="">
						<div class="menu-label">Doctor Diagnosis</div>
					</div>
				</pager>
			</v-scrollbar>
		</div>
	</section>
</template>

<script>
export default {
	name: 'Profile',
	// components: {Modal, ToggleSwitch},
	mounted: () => { document.title = "Profile | CleanHelt" },
	data() {return {
		page: 0,
	}},
	computed: {
		user() { return this.$parent.user }
	},
	methods: {
	}
}
</script>
