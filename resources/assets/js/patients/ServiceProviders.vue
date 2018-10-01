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
					<button @click="show = !show" class="button is-outlined is-rounded is-dark">
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
			<div v-preload v-if="loading" class="block is-rounded mx-15" style="height:10px;"/>	
			<pager align="top" :current="current">
				<div :slot="'p'+(index+1)" :key="index" class="px-15"
				   v-for="(shareKey, index) in ['Hospital', 'Doctor', 'Pharmacy', 'Laboratory']">
					<table class="table is-hoverable is-fullwidth">
						<tr>
							<th>Photo</th>
							<th>Provider Name</th>
							<th width="100">CHCODE</th>
							<th>Email</th>
							<th width="50">Status</th>
							<th>Actions</th>
						</tr>
						<tr v-show="share.visible" :key="index" v-for="(share, index) in shares[shareKey]">
							<td><i class="ti ti-user"></i> &nbsp;&nbsp;</td>
							<td>{{share.provider.name}}</td>
							<td class="has-text-grey-darker">{{share.provider.chcode}}</td>
							<td>{{share.provider.email}}</td>
							<td>
								<span v-if="share.status === 1" class="tag is-primary">Active</span>
								<span v-else-if="share.status === 0" class="tag is-info">Pending</span>
								<span v-else-if="share.status === 2" class="tag is-primary">Expired</span>
							</td>
							<td>
								<button @click="expire(share)" class="button has-no-motion is-normal is-small">
									<i class="ti ti-trash"></i> <span>Revoke Access</span>
								</button>
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
			this.$parent.fetchProfileShares().then(shares=> {
				this.loading = false;
				this.shares = this.groupSharesByDeparment(shares)				
			});
		},
		data() {return {
			loading: true,
			current: 0,
			show: true,
			shares: {},
		}},
		methods: {
			groupSharesByDeparment(shares = []) {
				const groups = {};
				shares.map(e => {
					const provider = e.provider_type;
					Object.keys(groups).includes(provider) && e.visible
						? groups[provider].push(e) 
						: (groups[provider] = []).push(e);
				})
				return groups;
			},
			success(share, res) {
				share.visible = false;
				this.$notify({duration: 3000, title: 'Access Revoked', text: `${share.provider.name}`, type: "info"});
			},
			expire(share) {
				this.$http.patch(`/api/patient/profile/shares/${share.id}/expire`)
					.then(this.success.bind(this, share));
			}
		}
	}
</script>
