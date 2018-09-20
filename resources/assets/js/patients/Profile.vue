<template>
	<section>
		<section class="content-top-bar">
			<h3>Profile</h3>
		</section>
		<div id="profile-grid">
			<aside>
				<img style="height: 100px; width: 100px" src="/images/assets/avatar.jpg" alt=""
					class="avatar has-shadow">
				<p class="subtitle is-5 mb-5 has-text-white">{{ user.full_name }}</p>
				<div class="has-text-right" style="width: 100%">
					<button class="button is-primary is-rounded">change photo <i class="ml-5 ti ti-pencil"></i></button>
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
						<accordion :show="true">
							<template slot="heading">Basic</template>
							<section slot="content">
								<table class="table is-narrow">
									<tr class="">
										<th width="150">Full Name</th>
										<td>{{ user.full_name }}</td>
									</tr>

<!-- 
	TODO: Add the Age detial
									<tr class="">
										<th>Age</th>
										<td>{{ new Date(user.dob).getFullYear() - new Date().getFullYear() }}</td>
									</tr>
									
 -->									 <tr class="">
										<th>Date of Birth</th>
										<td>{{ user.dob | moment('calendar', 'July 10, 1998') }}</td>
									</tr>
									<tr>
										<th>Email:</th>
										<td>{{ user.email }}</td>
									</tr>
									<tr>
										<th>Gender</th>
										<td>{{user.gender | ucfirst}}</td>
									</tr>
									<tr>
										<th>Address</th>
										<td>{{user.address}}</td>
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
						<accordion>
							<template slot="heading">Emergency Hospital</template>
							<section slot="content">
								<div v-if="!!user.emergency_hospital_name">
									<h3 class="m-0">{{ user.emergency_hospital_name }}</h3>
									<b class="m-0">Address:</b>
									<p>{{ user.emergency_hospital_address }}</p>
								</div>
								<div v-else>
									NOT PROVIDED YET!
								</div>
							</section>
						</accordion>
					    <accordion class="menu">
							<template slot="heading">Next of Kin<!-- Emergency Contact --></template>
							<section slot="content" class="content">
								<h1 class="title is-5 mb-0">{{ user.nok_name }}</h1>
								<div>
									<small>Email Address: {{ user.nok_email }}</small>
								</div>
								<div>
									<small>Phone Number: {{ user.nok_phone }}</small>
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
							<a @click.prevent="showModal(record, index)">{{ record.reference }}</a>
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
				<h3 class="title">Diagnosis</h3>
				<span>by Dr. {{ current.issuer.first_name }} {{ current.issuer.last_name}} {{ current.issuer.chcode }}</span>
				<hr>
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
			        	<div v-for="(answer, question) in current.data.extras" :key="question">
			        	 	<b>Question</b>: {{ question }} <br>
			        	 	<b>Answer</b>: {{ answer }}
			        	</div>
			        </section>
			        <hr>
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
				this.$set(this.records, getRecordKey(index), res.data.records));
		});
	},
	data() {return {
		page: 0,
		current: {data: {}, issuer: {}},
		records: {labtest: [], medicalRecord: [], prescription: []},
		modal: false,
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
		}
	}
}
</script>
