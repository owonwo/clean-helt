<template>
	<section>
		<section class="columns">
			<div class="column is-half">
				<h5 class="osq-group-subtitle-alt mb-15">Patient Profile</h5>
				<ProfileBox v-show="profile" class="is-fullwidth is-green">
					<h3 class="profile-title">{{ patient.name }}</h3>
					<p>{{ patient.gender | ucfirst }}</p>
					<div class="mt-30">
						<button @click="showProfile = true" class="button is-outlined is-rounded is-dark">Bio-Data</button>
						<router-link v-if="accountType === 'doctor'"
							:to="{name:'add-record', params: {chcode: patient.chcode, patient_id: patient.id }}" 
							class="button ml-10 is-outlined is-rounded is-dark">
							Add Record
						</router-link>
					</div>
				</ProfileBox>
				<section class="px-0">
					<accordion>
						<template slot="heading">Emergency Hospital</template>
						<section slot="content">
							<h3 class="m-0">{{ patient.emergency_hospital_name | ucfirst }}</h3>
							<b class="m-0">Address:</b>
							<p>{{ patient.emergency_hospital_address | ucfirst }}</p>
						</section>
					</accordion>
				    <accordion class="menu">
						<template slot="heading">Next of Kin<!-- Emergency Contact --></template>
						<section slot="content" class="content">
							<h1 class="title is-5 mb-0">{{ patient.nok_name }}</h1>
							<div>
								<small>Email Address: {{ patient.nok_email }}</small>
							</div>
							<div>
								<small>Phone Number: {{ patient.nok_phone }}</small>
							</div>
						</section>
					</accordion>
				</section>
				<hr/>
				<h1 class="osq-group-subtitle-alt mb-10">Medical History</h1>
				<div class="columns content is-multiline">
					<div v-if="showDiagnosis" class="column is-half is-fullheight">
						<router-link :to="recordsRoute('diagnosis')" tag="div" class="card pointed osq-text-primary card-content">Doctor's Diagnosis</router-link>
					</div>
					<div v-if="showLabTests" class="column is-half">
						<router-link :to="recordsRoute('labtest')" tag="div" class="card pointed osq-text-primary card-content">Laboratory Records</router-link>
					</div>
					<div v-if="showPrescription" class="column is-half">
						<router-link :to="recordsRoute('prescriptions')" tag="div" class="card pointed osq-text-primary card-content">Medicine Dispensing Records</router-link>
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
			<template slot="modal-title"><b>Bio-Data</b>: {{ patient.name }}</template>
			<table class="table is-borderless is-fullwidth">
				<tr>
					<td width="150">Full Name</td>
					<td>{{ patient.fullname }}</td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td>{{ patient.phone }}</td>
				</tr>
				<tr>
					<td>Age</td>
					<td>{{ patient.dob | moment("from") }}</td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>{{ patient.gender | ucfirst }}</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>{{ patient.address }}</td>
				</tr>
				<tr>
					<td>City</td>
					<td>{{ patient.city }}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{{ patient.state }}</td>
				</tr>
				<tr>
					<td>Country</td>
					<td>{{ patient.country }}</td>
				</tr>
			</table>
		</modal>
	</section>
</template>

<script>
	import Modal from '@/components/Modal.vue'
	import DoctorNote from '@/components/DoctorNote.vue'
	import {mapGetters} from 'vuex'

	export default {
		components: {DoctorNote, Modal},
		name: "PatientProfile",
		methods: {
			recordsRoute(type = "all") {
				const params = Object.assign(this.$route.params, {
					chcode: this.patient.chcode,
				});
				const query = {type};
				return {
					name: 'patient-records', 
					params,
					query
				}
			},
			getProfile() {
				let profile = this.$store.getters.getProfileByPatientId(this.getId());
				if("undefined" == typeof profile) 
					return  _.debounce(this.getProfile.bind(this), 2000)();
				this.profile = profile;
				this.patient = _.extend({}, this.profile.patient);
			},
			getId() {
				const patient_id = parseInt(this.$route.params.patient_id)
				_.isNumber(patient_id) || this.$router.replace({name: 'patients'})
				return patient_id;
			}
		},
		activated () {
			this.getProfile();
		},
		computed: {
			...mapGetters(['accountType']),
			showDiagnosis() {
				let {accountType: workspace} = this;
				return ['doctor', 'hospital'].includes(workspace);
			},
			showLabTests() {
				let {accountType: workspace} = this;
				return ['doctor', 'laboratory','hospital'].includes(workspace);				
			},
			showPrescription() { 
				let {accountType: workspace} = this;
				return ['pharmacy', "doctor" , "hospital"].includes(workspace);
			}
		},
		data() {return {
			settings: {
				 maxScrollbarLength: 60
			},
			profile: {},
			patient: {},
			showProfile: false,
		}}
	}
</script>
