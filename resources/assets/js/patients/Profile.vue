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
                                <save-edit-button :saved="edit.basic" @click="save_basic" />
                                <table class="table is-narrow">
                                    <tr class="">
                                        <th width="150">First Name</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.first_name }}</span>
                                            <input v-else class="input is-small" type="text" v-model="user.first_name">
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th>Last Name</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.last_name }}</span>
                                            <input v-else class="input is-small" type="text" v-model="user.last_name">
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th>Other Name</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.middle_name }}</span>
                                            <input v-else class="input is-small" type="text" v-model="user.middle_name">
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th>Date of Birth</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.dob | moment('calendar', 'July 10, 1998') }}</span>
                                            <input v-else class="input is-small" type="date" v-model="user.dob">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.email }}</span>
                                            <input v-else class="input is-small" type="email" v-model="user.email">
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
                                            <input v-else class="input is-small" type="text" v-model="user.city">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>State:</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.state }}</span>
                                            <input v-else class="input is-small" type="text" v-model="user.state">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Marital Status:</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.marital_status | ucfirst }}</span>
                                            <template v-else>
                                                <input type="radio" name="m_status" value="single" v-model="user.marital_status" /> Single
                                                <input type="radio" name="m_status" value="married" v-model="user.marital_status" /> Married
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number:</th>
                                        <td>
                                            <span v-if="!edit.basic">{{ user.phone }}</span>
                                            <input v-else class="input is-small" type="Number" v-model="user.phone">
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
                                <save-edit-button :saved="edit.emergency" @click="save_emerg" />
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
                                        <textarea class="textarea" v-model="user.emergency_hospital_address" placeholder="Address" row="5" />
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
					    <table class="table is-fullwidth" v-for="(insure, index) in records.insurance" :key="index">
							<tr>
								<td colspan="2"><h4 class="title is-5">{{insure.company_name}}</h4></td>
							</tr>
							<tr>
								<td>Insurance Provider Type</td>
								<td>{{ insure.insurance_type }}</td>
							</tr>
							<tr>
								<td>Company Name</td>
								<td>{{ insure.company_name }}</td>
							</tr>
							<tr>
								<td>Address</td>
								<td>{{insure.address}}</td>
							</tr>
							<tr>
								<td>City</td>
								<td>{{insure.city}}</td>
							</tr>
							<tr>
								<td>Phone</td>
								<td>{{insure.phone}}</td>
							</tr>
							<tr>
								<td>Emergency Phone</td>
								<td>{{insure.emergency_phone}}</td>
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
								<th>Title</th>
								<th>Age</th>
								<th width="120">Date</th>
							</tr>
							<tr v-for="(entry, index) in records.immunization" :key="index">
								<td>{{ index + 1 }}</td>
								<td>{{ entry.immunization_title }}</td>
								<td>{{ entry.age }}</td>
								<td>{{ entry.date_of_immunization }}</td>
							</tr>
						</table>
					</div>
					<!-- ALLERGIES -->
					<div slot="p8">
						<div class="level">
							<div class="menu-label">
								<span>ALLERGIES</span>
							</div>
							<HoverRevealButton @click="showModal('allergy')" class="mr-15 mt-5">
								<span class="ti ti-plus" slot="icon"></span>
								<span slot="text">Add</span>
							</HoverRevealButton>
						</div>
						<alert v-if="!records.allergy.length" type="info">
							You have a clean Allergy record.
						</alert>
						<table v-else class="table is-small is-fullwidth" style="font-size:small">
							<tr>
								<th>S/N</th>
								<th>Allergy</th>
								<th>Reaction</th>
								<th width="170">Date of Occurence</th>
								<th></th>
							</tr>
							<tr v-for="(entry, index) in records.allergy" :key="index">
								<td>{{index + 1}}</td>
								<td>{{entry.allergy}}</td>
								<td>{{entry.reaction}}</td>
								<td>{{entry.last_occurance}}</td>
								<td>
									<i class="ti ti-more-alt ti-rotate-3"></i>
								</td>
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
						<div class="mb-20" v-for="(entry) in records.hospitalization" :key="entry.id">
							<h1 class="title mb-5 is-5">{{ entry.hospitalization_type }}</h1>
							<p>Doctor: {{ entry.doctor}}</p>
							<p>Hospital: {{ entry.hospital}}</p>
							<p>Reason: {{entry.reason}}</p>
							<p>Complications: {{entry.complications}}</p>
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

		<modal :show="modal.show" @closed="modal = false">
			<CreateAllergy v-if="modal.form === 'allergy'" 
				@success="created('allergy')" @error="error('allergy')"/>
			<template slot="modal-footer">
			</template>
		</modal> 
	</section>
</template>

<script>
import EditProfile from '@/Mixins/EditProfile.js'
import ProfileGrid from '@/components/ProfileGrid.vue'
import CreateAllergy from '@/components/CreateAllergy.vue'

const delay = (time) => (result) => new Promise(resolve => setTimeout(() => resolve(result), time));

export default {
	name: 'Profile',
	components: {ProfileGrid, CreateAllergy},
	mixins: [EditProfile],
	mounted() { 
		document.title = "Profile | CleanHelt";
		this.fetchRecords();
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
		modal: {show: false, form: ''},
		diseases: ["Alcoholism","Asthma","Cancer","Diabetes","Heart Condition","Hepatitis","High Blood Pressure"],
		records: {labtest: [], insurance: [], hospitalization: [], allergy: [], immunization: [], medicalRecord: [], prescription: []},
	}},
	computed: {
		user() { return this.$parent.user },
	},
	methods: {
		showModal(form ) {
			this.modal = { show: true, form };
		},
		created(form) {
			this.fetchRecords()
			    .then(delay(1000))
				.then(this.notify('Allergy added to list', 'success'));
			this.closeModal();
		},
		error(form) {
			Promise.resolve()
				.then(this.notify('An error occured when creating Allergy .', 'error'));
		},
		fetchRecords() {
			const records = Object.keys(this.records);
			const XHRs = records.map(route => {
				return this.$parent.getRecord(route);
			});	
			const getRecordKey = (index) => {
				return records[index];
			}
			return Promise.all(XHRs).then((responses) => {
				responses.map((res, index) =>
					this.$set(this.records, getRecordKey(index), res.data.data || []));
			}).catch(err => {
				console.groupCollapsed('Patient Records Error')
				console.trace(err);
				console.groupEnd('Patient Records Error')
			});
		},
		notify(text, type) {
			return () => this.$notify({text, type});
		},
		closeModal(form = "") {
			this.modal = _.extend(this.modal, {show: false})
		}
	}
}
</script>