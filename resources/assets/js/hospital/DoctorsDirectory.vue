<template>
	<section>
		<section class="card">
			<section class="card-header">
				<div class="card-header-title" style="justify-content: space-between;">
					Doctor Directory
					<search-box style="width: 300px"
						shape="is-rounded" placeholder="Search" />
				</div>
			</section>
			<div class="card-content p-0">
				<div v-preload v-if="!!!doctors.length"
					class="block is-rounded mx-15 my-5 mb-0"
					style="height:10px;border-radius: 0"/>
				<table class="table is-hoverable is-fullwidth">
					<tr>
						<th class="has-text-centered">S/N</th>
						<th>Full Name</th>
						<th>Specialization</th>
						<th>CHCODE</th>
						<th>Options</th>
					</tr>
					<tr v-for="(doctor, key) in doctors" :key="key">
						<td class="has-text-centered">{{ key + 1}}</td>
						<td><router-link :to="{name: 'doctor-profile', params: {'_id': 1}}" tag="span">
							Dr. {{ doctor.first_name }} {{ doctor.last_name }}
						</router-link></td>
						<td>{{ doctor.specialization | ucfirst }}</td>
						<td>{{ doctor.chcode  }}</td>
						<td>
							<button @click="showAssignModal(doctor)" class="button is-hovered-success is-outlined is-rounded has-no-motion is-small">Assign</button>
						</td>
					</tr>
				</table>
			</div>
		</section>

		<modal :show="modal" size="sm" @closed="modal = false && isLoading.reset ">
			<div class="content is-center">
				<h5 class="title is-6">
					<i class="ti ti-share icon"></i> Assign Patient
				</h5>
				<div class="field">
					<select v-model="selected.share_id" class="input">
						<option value="0" disabled="" selected="">Select Patient...</option>
						<option :value="profile.id" v-for="(profile, index) in $store.state.sharedProfiles" :key="profile.id">
							{{profile.patient.chcode}} - {{ profile.patient.name }}
						</option>
					</select>
				</div>
				<div class="field">
					<button  
						v-if="!isLoading.loaded && selected.share_id !== 0"
						 @click="shareToDoctor()" 
						:class="{'is-loading': isLoading.message == 'loading'}"
						class="button is-fullwidth is-primary is-block is-outlined">
						Assign
					</button>
				</div>
			</div>
		</modal>
	</section>
</template>

<script>
export default {
	name: 'DoctorDirectory',
	created() {
		this.fetchDoctors();
	},
	data() {return {
		modal: false,
		doctors: [],
		isLoading: {message: "", loaded: false, get reset() {
			this.loaded = false,
			this.message = ""
		}},
		selected: {doctor_id: 0, share_id: 0},
	}},
	methods: {
		showAssignModal(doctor) {
			(this.modal = true)
			this.isLoading.reset
			this.selected.doctor_id = doctor.chcode
		},
		fetchDoctors() {
			this.$parent.getDoctors().then((res) => {
				this.doctors = res.data.doctors
			}).catch(function(err) {
				console.groupCollapsed('Doctor Directory Warnings')
				console.log(err);
				console.groupEnd();
			})
			console.log('fetching the doctors');
		},
		shareToDoctor() {
			let {share_id, doctor_id} = this.selected;
			this.isLoading.message = 'loading';
			this.$http.patch(`/api/hospital/patients/${share_id}/assign/${doctor_id}`)
				.then((res) => {
					this.modal = false;
					this.fetchDoctors();
				}).catch((err) => {
					console.log(err);
				});
		}
	}
}	
</script>
