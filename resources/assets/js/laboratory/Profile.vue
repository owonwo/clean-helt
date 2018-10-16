<template>
	<section>
		<div class="content-top-bar"> 
			<span>Profile Settings</span>
		</div>

		<profile-grid ref="grid" :avatar-url="edit.avatarUrl" :name="user.name" :avatar="user.avatar">
			<template slot="navigation">
				<li><a href="#">Basic Profile</a></li>
				<!-- <li><a href="#">Labor</a></li> -->
			</template>

			<template slot-scope="pager">
				<pager :current="pager.page">
					<section slot="p1">
						<div class="is-flex" style="justify-content: space-between;">
							<div class="menu-label">Basic Profile</div>
							<save-edit-button :saved="edit.basic" @click="save_basic"/>
						</div>
						<section slot="content">
							<table class="table is-borderless is-fullwidth">
								<tr>
									<th width="150">Name:</th>
									<td>
										<span v-if="!edit.basic">{{ user.name }}</span>
										<input v-else  class="input was-small" type="text" v-model="user.name">
									</td>
								</tr>
								<tr>
									<th>Email:</th>
									<td>
										<span v-if="!edit.basic">{{ user.email }}</span>
										<input v-else  class="input was-small" type="email" v-model="user.email">
									</td>
								</tr>
								<tr>
									<th>Phone:</th>
									<td>
										<span v-if="!edit.basic">{{ user.phone}}</span>
										<input v-else  class="input was-small" type="text" v-model="user.phone">
									</td>
								</tr>
								<tr>
									<th>Address:</th>
									<td>
										<span v-if="!edit.basic">{{ user.address }}</span>
										<textarea v-else  class="textarea" v-model="user.address"></textarea>
									</td> 
								</tr>
								<tr>
									<th>City:</th>
									<td>{{ user.city }}</td> 
								</tr>
								<tr>
									<th>State:</th>
									<td>{{ user.state }}</td>
								</tr>
								<tr>
									<th>Country:</th>
									<td>{{ user.country }}</td>
								</tr>
								<tr>
									<th>ID</th>
									<td>
										{{ user.chcode }}
										<button @click="copyTextToClipboard(user.chcode)" class="button is-small is-text">COPY</button>
									</td>
								</tr>
							</table>
						</section>
					</section>
			    </pager>
			</template>
		</profile-grid>
	</section>
</template>

<script>
import {mapGetters} from 'vuex'
import ProfileGrid from '@/components/ProfileGrid'
import EditProfile from '@/Mixins/EditProfile.js'


export default {
	name: "Profile",
	components: {ProfileGrid},
	mixins: [EditProfile],
	data() {return {
		modal: false,
		edit: {
			basic: false,
			url: '/api/laboratory/profile/update',
			avatarUrl: "/api/laboratory/profile/update/image",
			whiteList: ["name", "email", "phone", "address", "city", "state", "country", "website"],
		},
	}},
    computed: { 
    	hospitals () {return  this.$parent.hospitals || [] },
    	...mapGetters({user: 'getUser'}),
    },
	methods: {}
}
</script>
