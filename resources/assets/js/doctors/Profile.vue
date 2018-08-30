<template>
	<section>
		<div class="card mb-15">
			<div class="card-header"><div class="card-header-title">Your Profile</div></div>
			<div class="card-content p-10">
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
						<td>{{ $store.state.user.gender }}</td>
					</tr>
					<tr>
						<th>MDCN:</th>
						<td>{{ $store.state.user.folio }}</td>
					</tr>
					<tr>
						<th>Address</th>
						<td>{{ $store.state.user.profile.address || "" }}</td>
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

		<hgroup class="mb-10">
			<h1 class="osq-group-title mb-0">Hospitals</h1>
			<h6 class="">These are the <b class="osq-text-primary">Hospitals</b> you work in.</h6>
		</hgroup>

		<section class="columns is-multiline">
			<div class="column is-one-third-tablet" v-for="(hospital, index) in hospitals">
				<div class="card is-12">
					<div class="card-content">
						<span>{{ hospital }}</span>
						<span @click="showAlert(hospital)" class="ml-30 is-pulled-right"><i class="osf osf-remove"></i></span>
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
		hospitals: ['UPTH', 'BMH', 'Ken Saro Hospital', 'Javenic Rick Hospital']
	}},
    computed: { user() { return this.$parent.user }},
	methods: {
		showAlert(a) {
			this.currentHospital = a;
			this.modal = true;
		},
		removeHospital(hosp = "") {
			console.log(_.remove(this.hospitals, e => e == this.currentHospital));
			this.modal = false
		},
	}
}
</script>
