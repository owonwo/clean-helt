<template>
	<section>
		<section class="content-top-bar">
			<h3>{{ user.name }} Profile</h3>
		</section>
	    <profile-grid ref="grid" :avatar-url="edit.avatarUrl" :name="user.name" :avatar="user.avatar">
			<template slot="navigation">
				<li><a href="#">View Profile</a></li>
				<li><a href="#">View Admin Profile</a></li>
			</template>

			<template slot-scope="pager">
				<pager :current="pager.page">
					<section slot="p1">
						<div class="is-flex" style="justify-content: space-between;">
							<div class="menu-label">Hospital Information</div>
							<save-edit-button :saved="edit.basic" @click="save_basic"/>
						</div>
						<section slot="content">
							<table class="table is-fullwidth is-borderless">
								<tr class="">
									<th width="150">Name</th>
									<td>
										<span v-if="!edit.basic">{{ user.name }}</span>
										<input v-else v-model="user.name" type="text" class="input is-small" placeholder="Name">
									</td>
								</tr>
								<tr class="">
									<th>Email</th>
									<td>	
										<span v-if="!edit.basic">
											{{ user.email }}
										</span>
										<input v-else v-model="user.email" type="text" class="input is-small" placeholder="Email">
									</td>
								</tr>
								<tr> 
									<th>Telephone</th>
									<td>
										<span v-if="!edit.basic">{{user.phone}}</span>
										<input v-else v-model="user.phone" type="text" class="input is-small" placeholder="Telephone">
									</td>
								</tr>
								<tr>
									<th>Address</th>
									<td>
										<span v-if="!edit.basic">{{user.address}}</span>
										<textarea v-else v-model="user.address" class="textarea" placeholder="Address"></textarea>
									</td>
								</tr>
								<tr>
									<th>City</th>
									<td>
										<span v-if="!edit.basic">{{ user.city }}</span>
										<input v-else  class="input is-small" type="text" v-model="user.city">
									</td>
								</tr>
								<tr>
									<th>State:</th>
									<td>
										<span v-if="!edit.basic">{{ user.state }}</span>
										<input v-else  class="input is-small" type="text" v-model="user.state">
									</td>
								</tr>
								<tr>
									<th>Website</th>
									<td>
										<span v-if="!edit.basic">{{ user.website || 'http://' }} <a target="_blank" :href="user.website"><i class="ti ti-new-window"></i> </a></span>
										<input v-else v-model="user.website" type="text" class="input is-small" placeholder="http://hospital.org">
									</td>
								</tr>
								<tr>
									<th>ID</th>
									<td>
										{{ user.chcode }} &nbsp;&nbsp;
										<button @click="copyTextToClipboard(this.user.chcode)" class="button is-round is-small is-primary">COPY</button>
									</td>
								</tr>
							</table>
						</section>
					</section>

					<section slot="p2">
						<h1 class="menu-label">ADMINISTRATOR INFORMATION</h1>
					</section>
			    </pager>
			</template>
		</profile-grid>
	</section>
</template>

<script>
import {mapGetters} from 'vuex';
import ProfileGrid from '@/components/ProfileGrid'
import EditProfile from '@/Mixins/EditProfile.js'

export default {
	name: 'HospitalProfile',
    mixins: [EditProfile],
	components: {ProfileGrid},
	mounted() {
		document.title = "Hospital Profile | CleanHelt";
		// let updated = false;
		// const render = () => {
		// 	console.log('waiting for the user', this.user);
		// 	if(Object.keys(this.user).length > 3 && !updated) { 
		// 		updated = true;
		// 		this.$forceUpdate()
		// 	}else{
		// 		render();
		// 	}
		// }
		// _.debounce(render, 1000)();
	},
	data() {return {
		edit: {
			basic: false,
			url: '/api/hospital/profile',
			avatarUrl: "",
			whiteList: ["email", "phone", "address", "city", "state", "country", "website"],
		},
	}},
	computed: {
		...mapGetters({user: 'getUser'}),
	},
	methods: {}
}
</script>
