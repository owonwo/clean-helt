<template>
	<section>
		<section class="content-top-bar">
			<h3>{{ user.name }} Profile</h3>
		</section>
		<div id="profile-grid">
			<aside>
				<img style="height: 100px; width: 100px" src="/images/assets/avatar.jpg" alt=""
					class="avatar has-shadow">
				<p class="subtitle is-5 mb-5 has-text-white">{{ user.name }}</p>
				<div class="has-text-centered" style="width: 100%">
					<div class="is-small"><small>{{ user.chcode }}</small></div>
					<button class="button is-primary is-rounded">change logo <i class="ml-5 ti ti-pencil"></i></button>
				</div>
			</aside>
			<nav class="osq-sidenav p-10">
				<div class="menu">
					<ul v-pager-controls.prevent="{activeClass: 'active'}" class="menu-list">
						<li><a href="#">Information</a></li>
					</ul>
				</div>
			</nav>
			<v-scrollbar>
				<pager :current="page">
					<div slot="p1" class="">
						<div class="is-flex" style="justify-content: space-between;">
							<div class="menu-label">Hospital Information</div>
							<button class="button is-rounded is-outlined has-no-motion is-hovered-success">EDIT</button>
						</div>
						<section slot="content">
							<table class="table is-borderless">
								<tr class="">
									<th width="150">Name</th>
									<td>{{ user.name }}</td>
								</tr>
								<tr class="">
									<th>Email</th>
									<td>{{ user.email }}</td>
								</tr>
								<tr>
									<th>Telephone</th>
									<td>{{user.phone}}</td>
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
								<tr>
									<th>Website</th>
									<td>{{ user.website || 'http://' }}</td>
								</tr>
							</table>
						</section>
					</div>
				</pager>
			</v-scrollbar>
		</div>
	</section>
</template>

<script>
export default {
	name: 'HospitalProfile',
	// components: {Modal, ToggleSwitch},
	mounted: () => { document.title = "Hospital Profile | CleanHelt" },
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
