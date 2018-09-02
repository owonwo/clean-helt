<template>
	<section>
		<section class="columns">
			<div class="column is-half">
				<h5 class="osq-group-subtitle-alt mb-15">Patient Profile</h5>
				<ProfileBox v-show="profile" class="is-fullwidth is-green">
					<h3 class="profile-title">{{ profile.patient.full_name }}</h3>
					<p>{{ profile.patient.gender.toUpperCase() }}</p>
					<div class="mt-30">
						<button @click="showProfile = true" class="button is-outlined is-rounded is-dark">Bio-Data</button>
						<button class="button ml-10 is-outlined is-rounded is-dark">Add Record</button>
					</div>
				</ProfileBox>
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
						<template slot="heading">Next of Kin<!-- Emergency Contact --></template>
						<section slot="content" class="content">
							<h1 class="title is-5 mb-0">{{ profile.patient.nok_name }}</h1>
							<div>
								<small>Email Address: {{ profile.patient.nok_email }}</small>
							</div>
							<div>
								<small>Phone Number: {{ profile.patient.nok_phone }}</small>
							</div>
						</section>
					</accordion>
				</section>
				<hr/>
				<h1 class="osq-group-subtitle-alt mb-10">Medical History</h1>
				<div class="columns content is-multiline">
					<div class="column is-half is-fullheight">
						<router-link :to="recordsRoute('doctor')" tag="div" class="card pointed osq-text-primary card-content">Doctor's Diagnosis</router-link>
					</div>
					<div class="column is-half">
						<router-link :to="recordsRoute('laboratory')" tag="div" class="card pointed osq-text-primary card-content">Laboratory Records</router-link>
					</div>
					<div class="column is-half">
						<router-link :to="recordsRoute('pharmacy')" tag="div" class="card pointed osq-text-primary card-content">Medicine Dispensing Records</router-link>
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
			<template slot="modal-title"><b>Bio-Data</b>: {{ profile.patient.fullname() }}</template>
			<table class="table is-borderless is-fullwidth">
				<tr>
					<td width="150">Full Name</td>
					<td>{{ profile.patient.fullname() }}</td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td>{{ profile.patient.phone }}</td>
				</tr>
				<tr>
					<td>Age</td>
					<td>{{ profile.patient.dob | moment("from") }}</td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>{{ profile.patient.gender | ucfirst }}</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>{{ profile.patient.address }}</td>
				</tr>
				<tr>
					<td>City</td>
					<td>{{ profile.patient.city }}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{{ profile.patient.state }}</td>
				</tr>
				<tr>
					<td>Country</td>
					<td>{{ profile.patient.country }}</td>
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
	import {mapGetters} from 'vuex'

	export default {
		components: {Accordion, DoctorNote, Modal, vScrollbar},
		name: "PatientProfile",
		methods: {
			recordsRoute(type = "all") {
				const {params} = this.$route;
				const query = {type};

				return {name: 'patient-records', query}
			}
		},
		mounted() {
			const {$route} = this;
			const {patient_id} = $route.params
			this.profile = this.$store
				.getters.getProfileByPatientId(parseInt(patient_id));
			!_.isUndefined(this.profile) || this.$router.back()
		},
		data() {return {
			settings: {
				 maxScrollbarLength: 60
			},
			profile: {},
			showProfile: false,
		}}
	}
</script>
