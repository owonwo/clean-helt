<template>
	<section class="card">
		<div class="card-header">
			<!-- <span class="card-header-icon"><i class="icon osf osf-users"></i></span> -->
			<span class="card-header-title">Users</span>
		</div>
		<div class="tabs">
			<ul>
				<li  @click="current=0" :class="{'is-active': current == 0}"><a href="#">Patients</a></li>
				<li  @click="current=1" :class="{'is-active': current == 1}"><a href="#">Hospital</a></li>
				<li  @click="current=2" :class="{'is-active': current == 2}"><a href="#">Pharmacy</a></li>
				<li  @click="current=3" :class="{'is-active': current == 3}"><a href="#">Laboratory</a></li>
				<li  @click="current=4" :class="{'is-active': current == 4}"><a href="#">Doctors</a></li>
			</ul>
		</div>
		<pager align="top" :current="current">
			<div class="px-15" :slot="'p'+ai" :key="ai" v-for="ai in 5">
				<table class="table is-narrow is-hoverable is-fullwidth">
					<tr>
						<th>CHC</th>
						<th>Full Name</th>
						<th>Location</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Status</th>
					</tr>
					<tr v-for="(a) in 5">
						<td>#PH-300</td>
						<td>John Ayai Oghenetega</td>
						<td>27 Khana Street, D/Line</td>
						<td>081359597512</td>
						<td>john.ayai@gmail.com</td>
						<td>Active</td>
					</tr>
				</table>
			</div>
		</pager>
	</section>
</template>

<script>
	import Pager from '@/components/Pager.vue';

	export default {
		components: {Pager},
		name: 'Users',
		data() {return {
			current: 0,
			columns: [{}],
		}}
	}
</script>
