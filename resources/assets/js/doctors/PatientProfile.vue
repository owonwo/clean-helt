<template>
	<section>
		<section class="columns">
			<div class="column is-half">
				<h5 class="osq-group-subtitle-alt mb-15">Patient Profile</h5>
				<div class="card osq-profile-card is-fullwidth is-green is-landscape">
						<img src="$root.avatar" alt="" class="avatar">
						<div class="card-content has-text-right">
							<h3 class="profile-title">Mrs. Anita Lucas</h3>
							<p>FEMALE</p>
							<div class="mt-30">
								<button @click="showProfile = true" class="button is-outlined is-rounded is-dark">Bio-Data</button>
								<button class="button ml-10 is-outlined is-rounded is-dark">Add Record</button>
							</div>
						</div>
				</div>
				<section class="px-0">
					<accordion>
						<template slot="heading">Emergency Hospital</template>
						<section slot="content">
							<h3 class="m-0">EZ Hospitals</h3>
							<b class="m-0">Address:</b>
							<p>NO 35 WHIMPEY JUNCTION, RUMUEME. RIVERS STATE</p>
						</section>
					</accordion>
				    <accordion class="menu">
						<template slot="heading">Emergency Contact</template>
						<section slot="content" class="content">
							<table class="table is-bordered table-hoverable">
								<tr>
									<td>Brother</td>
									<td>+039958839288</td>
								</tr>
							</table>
						</section>
					</accordion>
				</section>
				<hr/>
				<h1 class="osq-group-subtitle-alt mb-10">Medical History</h1>
				<div class="columns content is-multiline">
					<div class="column is-half is-fullheight">
						<router-link :to="recordRoute('doctor')" tag="div" class="card pointed osq-text-primary card-content">Doctor's Diagnosis</router-link>
					</div>
					<div class="column is-half">
						<router-link :to="recordRoute('laboratory')" tag="div" class="card pointed osq-text-primary card-content">Laboratory Records</router-link>
					</div>
					<div class="column is-half">
						<router-link :to="recordRoute('pharmacy')" tag="div" class="card pointed osq-text-primary card-content">Medicine Dispensing Records</router-link>
					</div>
				</div>
			</div>

			<div class="column is-half">
				<h1 class="osq-group-subtitle-alt mb-10"><i class="osf osf-note osf-14px"></i> NOTES</h1>
				<v-scrollbar v-once :settings="settings" style="height:100vh">
					<DoctorNote class="mb-10" v-for="a in 4" :key="a"/>
				</v-scrollbar>
			</div>
		</section>

		<modal class="is-note" :show="showProfile" :show-header="true" @closed="showProfile = false">
			<template slot="modal-title"><b>Bio-Data</b>: Mrs. Anita Lucas</template>
			<table class="table is-borderless is-fullwidth">
				<tr>
					<td>Full Name</td>
					<td>Mrs. Anita Morrison</td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td>080121313414</td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>Female</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>24 Gbani Street, Diobu, Port-Harcourt.</td>
				</tr>
				<tr>
					<td>City</td>
					<td>Port Harcourt</td>
				</tr>
				<tr>
					<td>State</td>
					<td>Rivers State</td>
				</tr>
				<tr>
					<td>Country</td>
					<td>Nigeria</td>
				</tr>
			</table>
		</modal>
	</section>
</template>

<script>
	import Modal from '@/components/Modal.vue'
	import vScrollbar from 'vue-perfect-scrollbar'
	import Accordion from '@/components/Accordion.vue'
	import DoctorNote from '@/components/DoctorNote.vue'

	export default {
		components: {Accordion, DoctorNote, Modal, vScrollbar},
		name: "PatientProfile",
		methods: {
			recordRoute(type = "all") {
				const {params} =this.$route,
				      query = {type};

				return {name: 'patient-records', query}
			}
		},
		data() {return {
			settings: {
				 maxScrollbarLength: 60
			},
			showProfile: false,
		}},
	}
</script>
