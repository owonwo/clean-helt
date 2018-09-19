<template>
	<section>
		<section class="content-top-bar">
			<h3>Health Service Providers</h3>
		</section>

		<div class="columns is-centered" v-slide="show">
			<div class="column is-half">
				<AddServiceProvider class="has-text-centered" model="PATIENT" osq-style="fullwidth"/>
			</div>
		</div>
		
		<section class="card">
			<div class="card-header">
				<span class="card-header-icon"><i class="icon osf osf-department"></i></span>
				<span class="card-header-title">Departments</span>
				<div class="m-10">
					<button @click="show = !show" class="button is-outlined is-rounded is-white">
						<i class="ti" :class="[show ? 'ti-plus' : 'ti-angle-down']"></i>
					</button>
				</div>
			</div>
			<div class="tabs mb-5">
				<ul>
					<li v-for="(group, key, index) in shares" 
						:key="index" :class="{'is-active': current == index}">
						<a @click.prevent="current=index" href="#">{{ key }}</a>
					</li>
				</ul>
			</div>

			<pager align="top" :current="current">
				<div :slot="'p'+(index+1)" :key="index" class="px-15"
				   v-for="(shareKey, index) in ['Hospital', 'Doctor', 'Pharmacy', 'Laboratory']">
					<table class="table is-hoverable is-fullwidth">
						<tr>
							<th width="100">CHCODE</th>
							<th>Provider Name</th>
							<th>Email</th>
							<th width="50">Status</th>
						</tr>
						<tr :key="index" v-for="(share, index) in shares[shareKey]">
							<td>{{share.provider.chcode}}</td>
							<td>{{share.provider.name}}</td>
							<td>{{share.provider.email}}</td>
							<td>
								<span v-if="share.status === 1" class="tag is-primary">Active</span>
								<span v-else-if="share.status === 0" class="tag is-info">Pending</span>
								<span v-else-if="share.status === 2" class="tag is-primary">Expired</span>
							</td>
						</tr>
					</table>
				</div>
			</pager>
		</section>
	</section>
</template>

<script>
	import Pager from '@/components/Pager.vue';

	export default {
		components: {Pager},
		name: 'Departments',
		mounted() {
			this.$parent.fetchProfileShares();
		},
		data() {return {
			current: 0,
			show: true,
			columns: [{}],
		}},
		computed: {
			shares() { return this.groupSharesByDeparment(this.$parent.shares) }
		},
		methods: {
			groupSharesByDeparment(shares = []) {
				const groups = {};
				shares.map(e => {
					const provider = e.provider_type;
					Object.keys(groups).includes(provider) 
						? groups[provider].push(e) 
						: (groups[provider] = []).push(e);
				})
				return groups;
			}
		}
	}
</script>
