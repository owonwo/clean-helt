<template>
	<section>
		<section class="content-top-bar">
			<h3>Profile</h3>
		</section>
		<div id="profile-grid">
			<aside>
				<img style="height: 100px; width: 100px" :src="user.avatar" class="avatar has-shadow">
				<p class="subtitle is-4 my-10 has-text-white">{{ user.full_name }}</p>
				<div class="has-text-centered mt-5" style="width: 100%">
					<label for="change-avatar" class="button is-primary is-rounded">change photo <i class="ml-5 ti ti-pencil"></i></label>
					<input type="file" @change="changeAvatar($event)" id="change-avatar" style="position:absolute;left:0;width:0.1px;height: 0.1px;opacity:0"/>
				</div>
			</aside>
			<nav class="osq-sidenav p-10">
				<div class="menu">
					<ul v-pager-controls.prevent="{activeClass: 'active'}" class="menu-list">
						<li><a href="#">User Profile</a></li>
						<li class=""><a href="#">Pharmacy Dispensing Record</a></li>
						<li class=""><a href="#">Doctor's Diagnosis</a></li>
						<li class=""><a href="#">Lab Record</a></li>
					</ul>
				</div>
			</nav>
			<v-scrollbar>
				<pager :current="page">
					<div slot="p1" class="">
						<div class="menu-label">User Information</div>
						<accordion :show="false">
							<template slot="heading">Basic</template>
							<section slot="content">
								<save-edit-button :saved="edit.basic" @click="save_basic"/>
								<table class="table is-narrow">
									<tr class="">
										<th width="150">First Name</th>
										<td>
											<span v-if="!edit.basic">{{ user.first_name }}</span>
											<input v-else  class="input is-small" type="text" v-model="user.first_name">
										</td>
									</tr>
									<tr class="">
										<th>Last Name</th>
										<td>
											<span v-if="!edit.basic">{{ user.last_name }}</span>
											<input v-else  class="input is-small" type="text" v-model="user.last_name">
										</td>
									</tr>
									<tr class="">
										<th>Other Name</th>
										<td>
											<span v-if="!edit.basic">{{ user.middle_name }}</span>
											<input v-else  class="input is-small" type="text" v-model="user.middle_name">
										</td>
									</tr>
									<tr class="">
										<th>Date of Birth</th>
										<td>
											<span v-if="!edit.basic">{{ user.dob | moment('calendar', 'July 10, 1998') }}</span>
											<input v-else  class="input is-small" type="date" v-model="user.dob">
										</td>
									</tr>
									<tr>
										<th>Email:</th>
										<td>
											<span v-if="!edit.basic">{{ user.email }}</span>
											<input v-else  class="input is-small" type="email" v-model="user.email">
										</td>
									</tr>
									<tr>
										<th>Gender</th>
										<td>{{user.gender | ucfirst}}</td>
									</tr>
									<tr>
										<th>Address</th>
										<td>
											<span  v-if="!edit.basic">{{user.address}}</span>
											<textarea v-else v-model="user.address" rows="5" class="textarea"></textarea>
										</td>
									</tr>
									<tr>
										<th>City</th>
										<td>
											<span v-if="!edit.basic">{{ user.city }}</span>
											<input v-else  class="input is-small" type="text" v-model="user.city">
										</td>
									</tr>
									<tr>
										<th>State:</th>
										<td>
											<span v-if="!edit.basic">{{ user.state }}</span>
											<input v-else  class="input is-small" type="text" v-model="user.state">
										</td>
									</tr>
									<tr>
										<th>Marital Status:</th>
										<td>
											<span v-if="!edit.basic">{{ user.marital_status | ucfirst }}</span>
											<template v-else>
												<input type="radio" name="m_status" value="single" v-model="user.marital_status"/> Single
												<input type="radio" name="m_status" value="married" v-model="user.marital_status"/> Married
											</template>
										</td>
									</tr>
									<tr>
										<th>Phone Number:</th>
										<td>
											<span v-if="!edit.basic">{{ user.phone }}</span>
											<input v-else  class="input is-small" type="Number" v-model="user.phone">
										</td>
									</tr>
									<tr>
										<th>ID</th>
										<td>
											{{ user.chcode }} 
											<button class="button is-small is-text">COPY</button>
										</td>
									</tr>
								</table>
							</section>
						</accordion>
				    	<!-- Next of Kin -->
					    <accordion class="menu">
							<template slot="heading">Next of Kin</template>
							<section slot="content" class="content">
								<h1 class="title is-5 mb-10">{{ user.nok_name }}</h1>
								<div>
									<p>Email Address: <b>{{ user.nok_email }}</b></p>
								</div>
								<div>
									<p>Phone Number: <b>{{ user.nok_phone }}</b></p>
								</div>
							</section>
						</accordion>
						<!-- Emergency Contact -->
						<accordion :show=true>
							<template slot="heading">Emergency Hospital</template>
							<section slot="content">
								<save-edit-button :saved="!edit.emergency" @click="save_emerg"/>
								<div v-if="!edit.emergency">
									<h3 class="mb-5">{{ user.emergency_hospital_name }}</h3>
									<p style="opacity: 0.8">{{ user.emergency_hospital_address }}</p>
								</div>
								<div v-else>
									<div class="field">
										<input class="input" type="text" v-model="user.emergency_hospital_name" placeholder="Name">
									</div>
									<div class="field">
										<textarea class="textarea" v-model="user.emergency_hospital_address" placeholder="Address" row="5"/>
									</div>
								</div>
							</section>
						</accordion>
					</div>
					<div slot="p2">
						<h3 class="menu-label">Dispensing Records</h3>
					</div>
					<section slot="p3" class="">
						<div class="menu-label is-pulled-right">{{ records.medicalRecord.length }} Diagnosis Data</div>
						<div class="menu-label">Doctor Diagnosis</div>
						
						<div v-for="(record, index) in records.medicalRecord">
							<a class="has-text-primary" @click.prevent="showModal(record, index)">{{ record.reference }}</a>
							<p><small>by Dr. {{ record.issuer.first_name | ucfirst }} {{ record.issuer.last_name | ucfirst }}</small></p>
						</div>
					</section>
					<div slot="p4" class="">
						<div class="menu-label">Laboratory Tests</div>
					</div>
				</pager>
			</v-scrollbar>
		</div>

		<modal :show="modal" @closed="modal = false">
			<div class="content is-center">
				<div style="display: flex; justify-content: flex-start">
					<h3 class="title">Diagnosis</h3>
					<p>
						<span>by Dr. {{ current.issuer.first_name }} {{ current.issuer.last_name}}</span> <br> 
						<small class="has-text-primary">{{ current.issuer.chcode }}</small>
					</p>
				</div>
				<section v-if="'App\\Models\\Prescription' === current.type">
					<h3>Prescription</h3>
					<ul>
						<li>{{ current.data.name }}</li>
						<li>Frequency: {{ current.data.frequency }}</li>
						<li>Quantity: {{ current.data.frequency }}</li>
						<li> Status: 
							<span v-if="current.data.status" class="tag is-primary">dispensed</span>
							<span v-else class="tag is-danger">not dispensed</span>
						</li>
					</ul>
				</section>

				<section v-if="'App\\Models\\Diagnosis' === current.type">
					<!-- condition severity -->
			        <div>
			        	<h3 class="subtitle is-6">Condition Severity: {{current.data.patient_condition}}</h3>
			        </div>
					<section>
			        	<h3 class="subtitle is-5">Complaint History</h3>
						<div>{{current.data.complaint_history}}</div>
						<hr>
			        	<h3 class="subtitle is-5">Complaint Relationship</h3>						
				        <div>{{current.data.complaint_relationship}}</div>
					</section>
			        <hr>
			        <!-- symptoms -->
			        <section>
			        	<h1 class="subtitle is-5">Symptoms</h1>
			        	<div>
			        		<span style="font-size: 1rem" class="tag is-primary mr-15" v-for="(symptom, index) in current.data.symptoms">
			        			{{symptom}}
			        		</span>
			        	</div>
			        </section>
			        <hr>
			        <!-- questions -->
			        <section>
			        	<h1 class="subtitle is-5">Questions</h1>
			        	<div class="mb-10" v-for="(extra, index) in current.data.extras" :key="question">
			        	 	<span class="tag is-info">Question {{index + 1}}</span> {{ extra.question }} <br>
			        	 	<span class="tag is-primary">Answer</span> {{ extra.answer }}
			        	</div>
			        </section>
				</section>
				<hr>
				<div>
					<h3 class="title">Comment</h3>
					<p v-if="'App\\Models\\Diagnosis' === current.type">{{ current.data.comments }}</p>
					<p v-else-if="'App\\Models\\Prescription' === current.type">{{current.data.comment}}</p>
				</div>
			</div>
			<template slot="modal-footer">
			</template>
		</modal> 
	</section>
</template>

<script>
export default {
	name: 'Profile',
	mounted() { 
		document.title = "Profile | CleanHelt"
		const records = Object.keys(this.records);
		const XHRs = records.map(route => {
			return this.$parent.getRecord(route);
		});	
		const getRecordKey = (index) => {
			return records[index];
		}
		Promise.all(XHRs).then((responses) => {
			responses.map((res, index) =>
				this.$set(this.records, getRecordKey(index), res.data.data || []));
		});
	},
	data() {return {
		page: 0,
		edit: {
			emergency: false, 
			basic: false,
			whiteList: ["first_name", "middle_name", "last_name", "avatar", "email", "password", "dob", "gender", "phone", "address", "city", "state", "country", "religion", "marital_status", "nok_name", "nok_phone", "nok_email", "nok_address", "nok_city", "nok_state", "emergency_hospital_address", "emergency_hospital_name", "nok_country", "nok_relationship"],
		},
		modal: false,
		current: {data: {}, issuer: {}},
		records: {labtest: [], medicalRecord: [], prescription: []},
	}},
	computed: {
		user() { return this.$parent.user },
		modalData() {
			let {medicalRecord: index} = this.current;
			return this.records['medicalRecord'][index] || {};
		}
	},
	methods: {
		showModal(data, index) {	
			this.current = Object.assign({}, data);
			this.modal = true
		},
		closeModal() {
			this.current.reset();
			this.modal = false;
		},
		save_emerg() {
			if(this.edit.emergency === false) {
				this.edit.emergency = true;
			} else {
				const {emergency_hospital_name, emergency_hospital_address} = this.user;
				let data =  {emergency_hospital_name, emergency_hospital_address}
				this.$http.patch(`/api/patient/${this.user.chcode}/emergency`, data).then(response => {
					this.edit.emergency = false;
					this.$notify({text: 'Emergency Profile Updated!', type: 'success', duration: 2000});
				}).catch(err => {
					this.$notify({type:'error', text: err.response.data.message, duration: 2500});
				});
			}
		},
		save_basic() {
			if(this.edit.basic === false) {
				this.edit.basic = true;
			} else {
				let {edit, user} = this;
				let data = Object.assign({}, user);

				for(let key of Object.keys(data)) {	
					edit.whiteList.includes(key) || (delete data[key]);
				}
				this.$http.patch(`/api/patient/profile/update`, data).then(response => {
					this.edit.basic = false;
					this.$notify({text: 'Profile Updated!', type: 'success', duration: 2000});
				}).catch(err => {
					this.$notify({type:'error', text: err.response.data.message, duration: 2500});
				});
			}
		},
		updateAvatar(form) {
			this.$http.post('/api/patient/profile/update/image', form).then((res) => {
				this.$store.commit('set_avatar', res.data.path);
			}).catch(err => {
				this.$notify({type:'error', text: err.response.data.message, duration: 2500});
			});
		},
	}
}
</script>
