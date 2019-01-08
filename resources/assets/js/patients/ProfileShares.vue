<!-- eslint-disable -->
<template>
	<section>
		<section class="content-top-bar is-flex" style="justify-content: space-between; align-items: center">
			<h3>Profile Shares</h3>
		</section>

		<div class="columns is-centered" v-slide="show">
			<div class="column is-half">
				<AddServiceProvider @success="FETCH_ALL_SHARES" class="has-text-centered" model="PATIENT" osq-style="fullwidth"/>
			</div>
		</div>
		
		<section class="card is-fullheight">
			<div v-if="!allShares.length" class="card-header">
				<span class="card-header-icon"><i class="icon osf osf-department"></i></span>
				<span class="card-header-title">Service Provider.</span>
				<HoverRevealButton text="Add" @click="(show = !show)" class="mr-15 mt-5">
					<span class="ti" :class="{'ti-plus': show, 'ti-angle-down': !show}" slot="icon"></span>
					<span slot="text">{{ show ? 'Add' : 'Close' }}</span>
				</HoverRevealButton>
			</div>
			<div class="tabs mb-5">
				<ul>
					<li v-for="(group, key, index) in allShares" 
						:key="index" :class="{'is-active': current == index}">
						<a @click.prevent="current=index" href="#">{{ key }}</a>
					</li>
				</ul>
			</div>
			<div v-preload v-if="shares_loading" class="block is-rounded mx-15" style="height:10px;"/>	
			<div v-if="allShares.length < 1">
				<blockquote class="notification is-info p-5 mx-15">
					<i>Click the <b>Plus Button</b> (+) to add a Health Service Provider.</i>
				</blockquote>
			</div>
			<div class="card-body">
			<pager align="top" class="is-absolute" :current="current">
				<div :slot="'p'+(index+1)" :key="index" class="px-15"
				   v-for="(non, shareKey, index) in allShares">
					<table class="table is-hoverable is-fullwidth">
						<tr>
							<th>Photo</th>
							<th>Provider Name</th>
							<th width="100">CHCODE</th>
							<th>Expiration Date</th>
							<th>Status</th>
						</tr>
						<tr v-show="!isExpired(share)" :key="index" v-for="(share, index) in shares[shareKey]">
							<td><i class="ti ti-user"/> &nbsp;&nbsp;</td>
							<td>{{share.provider.name}}</td>
							<td class="has-text-grey-darker">{{share.provider.chcode}}</td>
							<td>{{ share.expired_at }}</td>
							<td>
								<span v-if="share.status === 1" class="tag is-primary">Active</span>
								<span v-else-if="share.status === 0" class="tag is-info">Pending</span>
								<span v-else-if="share.status === 2" class="tag is-danger">Expired</span>
								<dropdown>
									<template slot="list"> 
										<li v-if="share.status === 1" @click="showExtendModal(share)" class="dropdown-item">	
											<i class="ti ti-control-forward icon"/> <span>Extend Date</span>
										</li>
										<li v-if="share.status === 0 && !share.isSharedBy(user.id)" @click="approveShare(share.id)" class="dropdown-item">	
											<i class="ti ti-check icon"/> <span>Accept Share</span>
										</li>
										<li v-if="share.isAssigned() || share.isReferred()" @click="declineShare(share.id)" class="dropdown-item">
											<i class="ti ti-close icon"/> <span>Decline</span>
										</li>
										<li v-else @click="expireShare(share.id)" class="dropdown-item">
											<i class="ti ti-close icon"/> <span>Cancel</span>
										</li>
									</template>
								</dropdown>
							</td>
						</tr>
					</table>
				</div>
			</pager>
			</div>
		</section>
		<modal size="sm" :show="modal" :show-footer="false" @closed="modal=false">
			<hgroup class="has-text-centered mb-30">
				<h4 class="title is-5 mb-0">Extend Share</h4>
				<small>Extends the expiration time.</small>
			</hgroup>
			<div class="field">
				<input class="input" type="date" v-model="extension"/>
			</div>
			<template slot="modal-footer">
			<div class="has-text-centered">
				<button @click="extend(lastClicked)" class="button has-no-motion is-primary">
					<i class="ti ti-check icon"></i> <span>Extend</span>
				</button>
			</div>
			</template>
		</modal>
	</section>
</template>

<script> 
	/* eslint-disable */
	import { mapState, mapGetters, mapActions } from 'vuex'
	import Pager from '@/components/Pager.vue';

	export default {
		components: {Pager},
		name: 'ProfileShares',
		mounted() {
			this.FETCH_ALL_SHARES()
		},
		data() {return {
			current: 0,
			lastClicked: {},
			extension: "",
			show: true,
			modal: false
		}},
		computed: {
			...mapGetters({user: 'getUser'}),
			...mapState('patient_share', ['shares', 'shares_loading']),
			...mapGetters('patient_share', ['allShares'])
		},
		methods: {
			...mapActions('patient_share', ['FETCH_ALL_SHARES', 'approveShare', 'declineShare', 'expireShare']),
			showExtendModal(share) {
				this.modal = true
				this.lastClicked = share
				this.extension = this.$moment(share.expired_at).format("YYYY-MM-DD")
			},
			isExpired(share) {
				let {$moment} = this, 
					expiration_date = $moment(share.expired_at),
					now = $moment();
				return expiration_date.isSameOrBefore(now)
			},
			success(share, res) {
				share.visible = false;
				this.$notify({duration: 3000, title: 'Access Revoked', text: `${share.provider.name}`, type: "info"});
			},
			extend(share) {
				let {$moment, extension } = this;
				const data = { extension }

				extension = $moment(extension)
				!extension.isValid() 
				? this.error_message('Extended Date is invalid!')
				: this.$store.dispatch('patient_share/EXTEND_SHARE', {id: share.id, data})
					.then(() => {
						this.modal = false
						this.success_message('Profile Share Extended successfully!')
					})
				this.extension = "";
			}
		}
	}
</script>
