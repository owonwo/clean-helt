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
				<li v-for="(type, name, index) in client_types" :key="index" @click="current=index" :class="{'is-active': current == index}">
					<a href="#"><i class="icon" :class="[type.icon]"></i></a>
				</li>
			</ul>
		</div>
		<v-scrollbar style="max-height: 70vh">
			<pager align="top" :current="current">
				<!-- PATIENTS_TABLE -->
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
								<button @click="showModal('PATIENT', record.chcode)" class="button is-normal is-small">View</button>
								<span v-if="record.active == 1" class="tag is-success">Active</span>
								<span v-if="record.active == 0" class="tag is-danger">Inactive</span>
							</td>
						</tr>
					</table>
				</div>
				<!-- DOCTORS_TABLE -->
				<div class="px-15" slot="p2">
					<table class="table is-small is-hoverable is-fullwidth" style="font-size: smaller">
						<tr>
							<th>CH Code</th>
							<th>Full Name</th>
							<th>Folio</th>
							<th>Email</th>
							<th>Account Status</th>
							<th>Actions</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.doctors.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>Dr. {{ record.name }}</td>
							<td>{{ record.folio }}</td>
							<td>{{ record.email }}</td>
							<td>
								<span v-if="!!record.profile.active == true" class="tag is-success">
									unlocked
								</span>
								<span v-else class="tag is-danger">
									locked
								</span>
							</td>
							<td>
								<div class="buttons">
									<button @click="showModal('DOCTOR', record.chcode)" class="button is-normal is-small">
										View
									</button>
									<button v-if="!!record.profile.active == true" title="Lock"
										class="button is-small" @click="lock('DOCTOR', record)">
										<i class="ti ti-unlock"></i>
									</button>
									<button v-else title="Unlock" @click="unlock('DOCTOR', record)"
										class="button is-small">
										<i class="ti ti-lock"></i>
									</button>
									<button v-if="record.validation == true" class="button is-small  is-success">
										verified
									</button>
									<button @click="verifyDoctor(record)" v-if="record.validation == false" class="button  is-small is-danger">
										inactive
									</button>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="px-15" slot="p3">
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
								<button @click="showModal('PHARMACY', record.chcode)" class="button is-normal is-small">View</button>
								<span v-if="record.active == 1" class="tag is-success">verified</span>
								<span v-if="record.active == 0" class="tag is-danger">inactive</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="px-15" slot="p4">
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
								<span v-if="record.active == 0" class="tag is-info">inactive</span>
								<!-- <button @click="showModal('LABORATORY', record.chcode)" class="button is-normal is-small">View</button> -->
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
							<th>Status</th>
						</tr>
						<tr v-for="(record, index) in searchFilter(models.hospitals.data)" :key="index">
							<td>{{ record.chcode }}</td>
							<td>{{ record.name }}</td>
							<td>{{ record.phone }}</td>
							<td>{{ record.email }}</td>
							<td>
								<button @click="showModal('HOSPITAL', record.chcode)" class="button is-normal is-small">View</button>
								<span v-if="!!record.active == true" @click="lock('HOSPITAL', record)" class="button is-small is-success">
									Active
								</span>
								<span v-else @click="unlock('HOSPITAL', record)" class="button is-small is-danger">
									Inactive
								</span>
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

	const lockUrlMap = {
		modelMaps: Object.freeze({
			DOCTOR: `/api/admin/doctors/{chcode}/deactivate`,
			LABORATORY: `/api/admin/laboratories/{chcode}/deactivate`,
			PATIENT: `/api/admin/patients/{chcode}/deactivate`,					
		}),
		__proto: { 
			urlIsValid() { 
				return this.isValid 
			}, 
			url(chcode) { 
				return this._url.replace('{chcode}', chcode)
			},
			getUnlockUrl(chcode) {
				return this._url.replace('deactivate', 'activate').replace('{chcode}', chcode)
			},
			_url: '' ,
			isValid: false
		},
		find(model) {
			return Object.assign(this.__proto, {
				isValid: Object.keys(this.modelMaps).includes(model), 
				_url: this.modelMaps[model]
			});
		}
	}

	export default {
		components: {Pager},
		name: 'Users',
		data() {return {
			current: 0,
			modal: false,
			model: 'PATIENT',
			client_types: {
				Patients: {icon: 'osf osf-client-alt'},
				Doctors: {icon: 'osf osf-doctor'},
				Pharmacy: {icon: 'osf osf-pharmacy'},
				Laboratory: {icon: 'osf osf-lab'},
				Hospital: {icon: 'osf osf-hospital'},
			},
			preview: false,
			searchString: "",
		}},
		mounted() {
			const {personalify, addMethods} = this;

			this.model_keys.map((model) => {
				this.$parent.fetch(model).then((res) => {
					let accounts = res.data.data.data
					const users_info = accounts.map((d) => personalify(d)).map(addMethods);
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
		customMethods: {
			setActive(state = false) {
				(/^CHD/.test(this.chcode)) ? (this.profile.active = state) 
				// : (/^CHH/.test(this.chcode)) ? (this.active = false) 
				: (this.active = state);
			},
			activate() {
				this.setActive(true);
			},
			deactivate() {
				this.setActive(false);
			},
		},
		methods: {
			addMethods(account) {
				account = _.extend(Object.create(this.$options.customMethods), account);
				console.assert(!Object.keys(account).includes('activate'), "Error! AddMethods not appended to Object.");

				return account;
			},
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
			lock(model, account) {
				account.deactivate();
				const lockState = lockUrlMap.find(model);
				!lockState.urlIsValid() ||
					this.$http.patch(lockState.url(account.chcode)).catch(err => {
					account.activate();
				});
			},
			unlock(model, account) {
				account.activate();
				const lockState = lockUrlMap.find(model);
				!lockState.urlIsValid() ||
					this.$http.patch(lockState.getUnlockUrl(account.chcode)).catch(err => {
					account.deactivate();
				});
			},
			showModal(model, chcode) {
				this.model = model
				this.preview = chcode;
				this.modal = true;
			}
		}
	}
</script>
