<template>
	<section>
		<section class="card osq-table">
			<section class="card-header">
				<div class="card-header-title" style="justify-content: space-between;">
					DOCTORS DIRECTORY
					<search-box style="width: 300px" placeholder="Search for Doctor"></search-box>
				</div>
			</section>
			<div class="card-content p-0">
				<table class="table is-hoverable is-fullwidth">
					<tr>
						<th class="has-text-centered">S/N</th>
						<th>Full Name</th>
						<th>Specialization</th>
						<th>Status</th>
						<th>Options</th>
					</tr>
					<tr v-for="(a, index) in 6">
						<td class="has-text-centered">1</td>
						<td><router-link :to="{name: 'doctor-profile', params: {'_id': 1}}" tag="span">Dr. Joseph Owonvwon</router-link></td>
						<td>Specialist Dermatologist and Vereologist.</td>
						<td>
							<span v-if="index % 2 == 0">Online</span>
							<span v-else>Offline</span>
						</td>
						<td>
							<button v-if="index % 2 == 0" @click="modal = true" class="button is-danger is-outlined is-small">Revoke Access</button>
							<button v-else @click="modal = true" class="button is-success is-outlined is-small">Grant Access</button>
							<button class="button is-danger is-small">Block</button>
						</td>
					</tr>
				</table>
			</div>
		</section>

		<modal :show="modal" @closed="modal = false">
			<div class="content is-center">
				<h1 class="is-centered"><center>Access Revoke Confirm.</center></h1>
				<p>Revoking access for doctor will deny every request to access the patients information 
				and will disconnect all pending transactions.</p>
			</div>
			<template slot="modal-footer">
				<div class="column has-text-centered">
					<button @click="revokeAccess" class="button is-danger">Yes</button>
					<button @click="modal = false" class="button is-success">No</button>
				</div>
			</template>
		</modal>
	</section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import SearchBox from '@/components/SearchBox.vue'

export default {
	name: 'Dashboard',
	components: {Modal, SearchBox},
	data() {return {
		modal: false,
	}},
	methods: {
		revokeAccess() {
			this.modal = false
		}
	}
}	
</script>
