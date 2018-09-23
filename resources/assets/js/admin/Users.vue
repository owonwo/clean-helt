<template>
	<section class="card">
		<div class="card-header">
			<!-- <span class="card-header-icon"><i class="icon osf osf-users"></i></span> -->
			<nav class="card-header-title" style="justify-content: space-between;">
				<span>CleanHelt Users</span>
				<search-box @value="e => searchString = e" style="width: 300px"
					shape="is-rounded" placeholder="Search" />
			</nav>
		</div>
		<div class="tabs mb-0">
			<ul>
				<li  @click="current=0" :class="{'is-active': current == 0}"><a href="#">Patients</a></li>
				<li  @click="current=1" :class="{'is-active': current == 1}"><a href="#">Doctors</a></li>
				<li  @click="current=2" :class="{'is-active': current == 2}"><a href="#">Hospital</a></li>
				<li  @click="current=3" :class="{'is-active': current == 3}"><a href="#">Pharmacy</a></li>
				<li  @click="current=4" :class="{'is-active': current == 4}"><a href="#">Laboratory</a></li>
			</ul>
		</div>
		<v-scrollbar style="max-height: 70vh">
			<pager align="top" :current="current">
				<div class="px-15" slot="p1">
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Full Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.patients.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>{{ record.name }}</td>
							<td>{{ record.phone }}</td>
							<td>{{ record.email }}</td>
							<td>
								<span v-if="record.active == 1" class="tag is-success">Active</span>
								<span v-if="record.active == 0" class="tag is-danger">Inactive</span>
								<button @click="showModal('PATIENT', record.chcode)" class="button is-normal is-small">View</button>
							</td>
						</tr>
					</table>
				</div>	
				<div class="px-15" slot="p2">
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Full Name</th>
							<th>Folio</th>
							<th>Email</th>
							<th>Specialization</th>
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.doctors.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>Dr. {{ record.name }}</td>
							<td>{{ record.folio }}</td>
							<td>{{ record.email }}</td>
							<td>{{ record.specialization }}</td>
							<td>
								<span v-if="record.validation == true" class="tag is-success">verified</span>
								<span v-if="record.validation == false" class="button is-small is-info" @click="verifyDoctor(record)">unverified</span>
								<button @click="showModal('DOCTOR', record.chcode)" class="button is-normal is-small">View</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="px-15" slot="p3">
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Name</th>
							<th>Telephone</th>
							<th>Email</th>
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.hospitals.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>{{ record.name }}</td>
							<td>{{ record.phone }}</td>
							<td>{{ record.email }}</td>
							<td>
								<span v-if="record.active == 1" @click="deactivate('HOSPITAL')" class="button is-small is-success">Active</span>
								<span v-if="record.active == 0" @click="activate('HOSPITAL')" class="button is-small is-info">Inactive</span>
								<button @click="showModal('HOSPITAL', record.chcode)" class="button is-normal is-small">View</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="px-15" slot="p4">
					<!-- pharmacies table -->
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Name</th>
							<th>Telephone</th>
							<th>Email</th>
							<th>State</th>
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.pharmacies.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>{{ record.name }}</td>
							<td>{{ record.phone }}</td>
							<td>{{ record.email }}</td>
							<td>{{ record.state }}</td>
							<td>
								<span v-if="record.active == 1" class="tag is-success">verified</span>
								<span v-if="record.active == 0" class="tag is-info">unverified</span>
								<button @click="showModal('PHARMACY', record.chcode)" class="button is-normal is-small">View</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="px-15" slot="p5">
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Name</th>
							<th>Telephone</th>
							<th>Email</th>
							<th>State</th>
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.labs.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>{{ record.name }}</td>
							<td>{{ record.phone }}</td>
							<td>{{ record.email }}</td>
							<td>{{ record.state }}</td>
							<td>
								<span v-if="record.active == 1" class="tag is-success">verified</span>
								<span v-if="record.active == 0" class="tag is-info">unverified</span>
								<!-- <button @click="showModal('LABORATORY', record.chcode)" class="button is-normal is-small">View</button> -->
							</td>
						</tr>
					</table>
				</div>
			</pager>
		</v-scrollbar>

		<modal :show-header="true" :show="modal" @closed="modal = false">
			<section>
				<ProfileLoader :of="model" by="ADMIN" :chcode="preview"/>
			</section>
		</modal>
	</section>
</template>

<script>
	import Pager from '@/components/Pager.vue';

	export default {
		components: {Pager},
		name: 'Users',
		data() {return {
			current: 0,
			modal: false,
			model: 'PATIENT',
			preview: false,
			searchString: "",
		}},
		mounted() {
			const {personalify} = this;

			this.model_keys.map((model) => {
				this.$parent.fetch(model).then((res) => {
					const users_info = res.data.data.data.map((d) => personalify(d));
					this.$set(this.models, model, {data: users_info});
				});
			});
		},
		computed: {
			models() {
				return this.$parent.models;
			},
			model_keys() { return Object.keys(this.models) }
		},
		methods: {
			searchFilter(e) {
				return (e ||  []).filter(e => 
					e.chcode.toLowerCase()
						.includes(this.searchString.toLowerCase())
				)
			},
			verifyDoctor(doctor) {
				doctor.validation = true;
				this.$http.patch(`/api/admin/doctors/verify/${doctor.chcode}`).catch((res) => {
					doctor.validation = false;
					this.$notify({
						group: 'main', text: 'Doctor verification failed!',
						type: 'error'
					});
				})
			},
			deactivate(model) {
				
			},
			showModal(model, chcode) {
				this.model = model
				this.preview = chcode;
				this.modal = true;
			}
		}
	}
</script>
