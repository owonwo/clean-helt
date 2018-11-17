<template>
	<section>
		<section class="content-top-bar">
			<h3>Profile</h3>
		</section>
 
		<profile-grid :name="user.full_name" :avatar="user.avatar" :avatar-url="edit.avatarUrl">
			<template slot="navigation" class="osq-sidenav p-10">
				<li><a href="#">Basic Information</a></li>
				<li class=""><a href="#">Annual Medical Check</a></li>
				<li class=""><a href="#">Medical History</a></li>
				<li class=""><a href="#">Hospital Contacts</a></li>
				<li class=""><a href="#">Health Insurance Providers</a></li>
				<li class=""><a href="#">Emergency Contacts</a></li>
				<li class=""><a href="#">Immunization</a></li>
				<li class=""><a href="#">Allergies</a></li>
				<li class=""><a href="#">Family Medical History</a></li>
				<li class=""><a href="#">Hospitalization</a></li>
				<li class=""><a href="#">Health Log</a></li>
			</template>
			<template slot-scope="pager">
				<pager :current="pager.page">
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
											<button @click="copyTextToClipboard(user.chcode)" class="button is-small is-text">COPY</button>
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
								<save-edit-button :saved="edit.emergency" @click="save_emerg"/>
								<div v-if="!edit.emergency">
									<span v-if="!user.emergency_hospital_name">No Emergency Address Yet</span>
									<template v-else>
										<h3 class="mb-5">{{ user.emergency_hospital_name }}</h3>
										<p style="opacity: 0.8">{{ user.emergency_hospital_address }}</p>
									</template>
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
						<h3 class="menu-label">Annual Medical Check</h3>
						<h5>Vital Signs</h5>
						<table class="ml-30 mb-30" style="font-size: 13px">
							<tr>
								<td width="104px">Pulse:</td>
								<td>95bmp</td>
							</tr>
							<tr>
								<td>Temperature:</td>
								<td>31&deg;C</td>
							</tr>
							<tr>
								<td>Blood Pressure:</td>
								<td>120/80 mmHg</td>
							</tr>
							<tr>
								<td>Respiratory Rate:</td>
								<td>16 breaths per minute</td>
							</tr>
						</table>
						<h5>Examination of systems</h5>
						<p class="ml-30 mb-30" style="font-size: 0.8em">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet</p>
						<h5>Additional Information</h5>
					</div>
					<section slot="p3" class="">
						<div class="menu-label">Medical History</div>
						<table class="table is-fullwidth">
							<thead>
								<tr>
									<th>Illness</th>
									<th>Date of Onset</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Acquired Immundefiiency Syndrome (AIDS or HIV Positive)</td>
									<td>00/00/0000</td>
								</tr>
								<tr>
									<td>Arthritis</td>
									<td>00/00/0000</td>
								</tr>
								<tr>
									<td>Asthma</td>
									<td>00/00/0000</td>
								</tr>
								<tr>
									<td>Bronchitis</td>
									<td>00/00/0000</td>
								</tr>
								<tr>
									<td>Cancer</td>
									<td>00/00/0000</td>
								</tr>
							</tbody>
						</table>	
					</section>
					<!-- HOSPITAL CONTACTS -->
					<div slot="p4" class="">
						
						<div class="menu-label">HOSPITAL CONTACTS</div>
						<div class="hospital-card is-small">
							<h5 class="title is-size-5 mb-10">Hospital 1</h5>
							<p class="is-size-6">St Immanuel Memorial Hospital</p>
							<ul class="is-size-7">
								<li>Location: Tecno junction, Rumuola, Port Harcourt</li>
								<li>Phone: 08034353580, 0904738745</li>
								<li>Emails: stimmanuel@yahoo.com, info@stimmanuelmemorialhospital.com</li>
							</ul>
						</div>

						<div class="hospital-card is-small">
							<h5 class="title is-size-5 mb-10">Hospital 1</h5>
							<p class="is-size-6">St Immanuel Memorial Hospital</p>
							<ul class="is-size-7">
								<li>Location: Tecno junction, Rumuola, Port Harcourt</li>
								<li>Phone: 08034353580, 0904738745</li>
								<li>Emails: stimmanuel@yahoo.com, info@stimmanuelmemorialhospital.com</li>
							</ul>
						</div>
					</div>
					<!-- HEALTH INSURANCE PROVIDERS -->
					<div slot="p5">
						<div class="menu-label">HEALTH INSUREANCE PROVIDER</div>
						<table class="table is-fullwidth">
							<tr>
								<td>Insurance Provider Type</td>
								<td>Leadway Insurance</td>
							</tr>
							<tr>
								<td>Company Name</td>
								<td>ABC Locks</td>
							</tr>
							<tr>
								<td>Address</td>
								<td>City</td>
							</tr>
							<tr>
								<td>City</td>
								<td>Lop</td>
							</tr>
							<tr>
								<td>Phone</td>
								<td>039903990</td>
							</tr>
							<tr>
								<td>Emergency Phone</td>
								<td>0399409309</td>
							</tr>
						</table>
					</div>
					<!-- EMERGENCY CONTACT -->
					<div slot="p6">
						<div class="menu-label">Emergency Contact</div>
					</div>
					<!-- Immunization -->
					<div slot="p7">
						<div class="menu-">IMMUNIZATIONS</div>
						<table class="table is-fullwidth">
							<tr>
								<th>S/N</th>
								<th>Age</th>
								<th>Title</th>
								<th width="120">Date</th>
							</tr>
							<tr v-for="(entry, index) in records.immunization">
								<td>{{ index + 1 }}</td>
								<td>{{ entry.age }}</td>
								<td>{{ entry.immunization_title }}</td>
								<td>{{ entry.date_of_immunization }}</td>
							</tr>
						</table>
					</div>
					<!-- ALLERGIES -->
					<div slot="p8">
						<div class="menu-label">ALLERGIES</div>
						<table class="table is-fullwidth">
							<tr>
								<th>Allergy</th>
								<th>Reaction</th>
								<th>Date of Occurence</th>
							</tr>
							<tr v-for="(entry, index) in record.allergy">
								<td>{{entry.name}}</td>
							</tr>
						</table>
					</div>
					<!-- FAMILY MEDICAL HISTORY -->
					<div slot="p9">
						<div class="menu-label">FAMILY MEDICAL HISTORY</div>
						<table class="table is-fullwidth">
							<tr>
								<th></th>
								<th v-for="(title, key) in family" :key="key">{{ title }}</th>
							</tr>
							<tr v-for="disease in diseases" :key="disease">
								<td>{{disease}}</td>
								<td class="has-text-centered" :key="key" v-for="(title, key) in family">
									<input type="checkbox" value="title">
								</td>
							</tr>
						</table>
					</div>
					<!-- HOSPITALIZATION -->
					<div slot="p10">
						<div class="menu-label">HOSPITALIZATION</div>
						<div>
							Hospital A
							<p>Doctor: James Looker</p>
							<p>Hospital: James Looker</p>
							<p>Reason: James Looker</p>
							<p>Complications: James Looker</p>
						</div>
					</div>
					<!-- HEALTH LOGS -->
					<div slot="p11">
						<div class="menu-label">HEALTH LOG</div>
						<table class="table is-fullwidth">
							<tr>
								<th width="150">Date</th>
								<th>Nature of Health Problem</th>
							</tr>
							<tr>
								<td>2018-30-05</td>
								<td>Dr Patrick Odunze has accepted to view your Medical Profile</td>
							</tr>
						</table>
					</div>
				</pager>
			</template>
		</profile-grid>

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
import EditProfile from '@/Mixins/EditProfile.js'
import ProfileGrid from '@/components/ProfileGrid.vue'

export default {
	name: 'Profile',
	components: {ProfileGrid},
	mixins: [EditProfile],
	mounted() { 
		document.title = "Profile | CleanHelt";
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
			basic: false,
			emergency: false,
			avatarUrl: '/api/patient/profile/update/image',
			url: `/api/patient/profile/update`,
			whiteList: [
				"first_name",
				"middle_name",
				"last_name",
				"avatar",
				"email",
				"password",
				"dob",
				"gender",
				"phone",
				"address",
				"city",
				"state",
				"country",
				"religion",
				"marital_status",
				"nok_name",
				"nok_phone",
				"nok_email",
				"nok_address",
				"nok_city",
				"nok_state",
				"emergency_hospital_address",
				"emergency_hospital_name",
				"nok_country",
				"nok_relationship"
			],
		},
		/**
		  *@type <Array["string"]>
		  */
		family: ["Mother", "Father", "Sibling", "Grand Parent", "Child"],
		diseases: ["Alcoholism","Asthma","Cancer","Diabetes","Heart Condition","Hepatitis","High Blood Pressure"],
		modal: false,
		current: {data: {}, issuer: {}},
		records: {labtest: [], allergy: [], immunization: [], medicalRecord: [], prescription: []},
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
