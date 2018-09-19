<template>
	<section>
		<div class="card mb-15">
			<div class="card-header"><div class="card-header-title">Your Profile</div></div>
			<div class="card-content has-text-centered columns p-10">
				<figure class="column is-one-third">
					<img src="/images/assets/avatar.jpg" class="my-10" style="width: 200px;
						height: 250px;
						object-fit: cover;
						border-radius: 1px 1px 1px 1px;">
					<figcaption class="title is-5">{{ user.name }}</figcaption>
					<div><small class="is-spaced tag is-primary">PHARMACY</small></div>
				</figure>

				<div class="column">
					<table class="table is-borderless is-fullwidth">
						<tr>
							<th>Name:</th>
							<td>{{ user.name }}</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>{{ user.email }}</td>
						</tr>
						<tr>
							<th>Phone:</th>
							<td>{{ user.phone }}</td>
						</tr>
						<tr>
							<th>Address</th>
							<td>{{ user.address }}</td> 
						</tr>
						<tr>
							<th>City</th>
							<td>{{ user.city }}</td> 
						</tr>
						<tr>
							<th>State</th>
							<td>{{ user.state }}</td>
						</tr>
						<tr>
							<th>Country</th>
							<td>{{ user.country }}</td>
						</tr>
						<tr>
							<th>Registration No.:</th>
							<td>{{ user.chief_pharmacist_reg}}</td>
						</tr>
						<tr>
							<th>ID</th>
							<td>
								{{ user.chcode }}
								<button class="button is-small is-text">COPY</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
	name: "Profile",
	data() {return {
		modal: false,
	}},
    computed: { 
    	hospitals () {return  this.$parent.hospitals || [] },
    	...mapGetters({user: 'getUser'}),
    },
	methods: {}
}
</script>
