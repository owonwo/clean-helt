<template>
	<section>
		<div class="card mb-15">
			<div class="card-header"><div class="card-header-title">Your Profile</div></div>
			<div class="card-content has-text-centered columns p-10">
				<figure class="column is-one-third">
					<img src="/images/assets/avatar.jpg" class="my-10" style="width: 250px;
						height: 250px;
						object-fit: cover;
						border-radius: 1px 1px 1px 1px;">
					<figcaption class="title is-5">Dr. {{ user.full_name }}</figcaption>
				</figure>

				<div class="column">
					<table class="table is-borderless is-fullwidth">
						<tr>
							<th width="20%">Full Name:</th>
							<td>{{ $store.state.user.full_name }}</td>
						</tr>
						<tr>
							<th>Specialization:</th>
							<td>{{ $store.state.user.specialization | ucfirst }}</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>{{ $store.state.user.email }}</td>
						</tr>
						<tr>
							<th>Gender:</th>
							<td>{{ $store.state.user.gender | ucfirst }}</td>
						</tr>
						<tr>
							<th>MDCN:</th>
							<td>{{ $store.state.user.folio }}</td>
						</tr>
						<tr>
							<th>Address</th>
							<td>{{ $store.state.user.profile.address }}</td> 
						</tr>
						<tr>
							<th>State</th>
							<td>{{ $store.state.user.profile.state }}</td>
						</tr>
						<tr>
							<th>ID</th>
							<td>
								{{ $store.state.user.chcode }}
								<button class="button is-small is-text">COPY</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<hgroup class="mb-10">
			<h1 class="osq-group-title mb-0">Hospitals</h1>
			<h6 v-if="hospitals.length > 0" class="">These are the Hospitals you work in.</h6>
			<h6 v-if="!!!hospitals.length" class="notification is-info">
				<span class="ml-i-15 mr-10"><i class="ti ti-info"></i></span>
				You currently don't work for any hospital</h6>
		</hgroup>
		
		<section class="columns is-multiline">
			<div class="column is-one-third-tablet" v-for="(hospital, index) in hospitals">
				<div class="card is-12">
					<div class="card-content">
						<div>
							<b class="osq-text-primary">{{ hospital.name }}</b> 
						</div>
						<small class="">{{ hospital.chcode }}</small>

						<div class="mt-15 has-text-right">
							<button class="button is-hovered-danger" @click="showAlert(hospital)"><i class="ti ti-trash"></i></button>
						</div>
					</div>
				</div>
			</div>
		</section>

		<modal :show="modal" @closed="modal = false">
			<div class="content is-center">
				<h1 class="is-centered"><center>Are you sure you want to leave?</center></h1>
				<p>Please understand that all access and privilege to this Hospital will be lost if removed.</p>
			</div>
			<template slot="modal-footer">
				<div class="column has-text-centered">
					<button @click="removeHospital" class="button is-danger">Yes</button>
					<button @click="modal = false" class="button is-success">No</button>
				</div>
			</template>
		</modal> 
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'

export default {
	name: "Profile",
	components: {Modal},
	data() {return {
		modal: false,
		currentHospital: "",
	}},
    computed: { 
    	hospitals () {return  this.$parent.hospitals || [] },
    	user() { return this.$parent.user }
    },
	methods: {
		showAlert(a) {
			this.currentHospital = a;
			this.modal = true;
		},
		removeHospital(hosp = "") {
			this.$parent.manageHospital(this.currentHospital, 'remove');
			this.modal = false;
		},
	}
}
</script>
