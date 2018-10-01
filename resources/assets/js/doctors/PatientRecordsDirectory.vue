<template>
	<section>
		<!-- diagnosis -->
		<section v-if="$route.query.type === 'diagnosis'" class="content">
			<h5>Diagnosis Records</h5>
			<table class="table is-bordered is-fullwidth table-hoverable" style="font-size: smaller">
				<tr>
					<th class="has-text-centered">S/N</th>
					<th>References</th>
					<th>Comment</th>
					<th>Issuer</th>
					<th>Preview</th>
				</tr>
				<tr v-for="(record, index) of records" :key="index">
					<td class="has-text-centered">{{ index + 1 }}</td>
					<td>{{ record.reference }}</td>
					<td>{{ record.data.comments }}</td>
					<td>{{ record.issuer.fullname }}</td>
					<td>
						<button @click="showModal(record)" class="button is-small is-primary is-outlined">
							View Record
						</button>
					</td>
				</tr>
			</table>
		</section>
		<section v-if="$route.query.type === 'prescriptions'" class="content">
			<div class="content-top-bar">
				<h3>Medicine Dispensing Record</h3>
			</div>
			<table class="table is-fullwidth is-bordered">
				<tr>
					<th width="50">S/N</th>
					<th>Prescription</th>
					<th width="50">Quantity</th>
					<th width="50">Frequency</th>
					<th>Issuer</th>
					<th>Comment</th>
					<th>
						Status
					</th>
				</tr>
				<tr v-for="(record, index) in records" :key="index">
					<td class="has-text-centered">{{ index + 1}}</td>
					<td><a href="#">{{ record.data.name }}</a></td>
					<td class="has-text-centered">{{ record.data.quantity }}</td>
					<td class="has-text-centered">{{ record.data.frequency }}</td>
					<td>Dr. {{ record.issuer.first_name }} {{ record.issuer.last_name }}</td>
					<td>{{ record.data.comment | truncate(50) }}</td>
					<td>
						<button v-if="accountType === 'pharmacy' && record.data.status == 0" @click="dispense(record)" class="button is-rounded has-shadow is-primary">Dispense</button>
						<span v-else-if="!!record.data.status" class="tag is-primary">dispensed</span>
						<span v-else class="tag is-danger">not dispensed</span>
					</td>
				</tr>
			</table>
		</section>

		<Modal class="is-note" :show="showRecordModal" :show-header="false" @closed="showRecordModal = false">
			<div class="content is-center">
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
			<section v-if="$route.query.type === 'pharmacy'" class="content">
				<hgroup>
					<h3 class="mb-5">MEDICATION DISPENSED</h3>
					<span class="mb-5">by <b class="osq-text-primary">{{physician}}</b> at <b class="osq-text-primary">{{ time }}</b></span>
				</hgroup>
				<hr>
				<h5>Prescriptions</h5>
				<div class="menu is-medium mb-15">
					<ul>
						<li class="menu-list" v-for="a in prescriptions">{{ a }}</li>
					</ul>
				</div>
				<h5>Dispensed</h5>
				<div class="menu is-medium mb-15">
					<ul>
						<li class="menu-list" v-for="a in dispensed">{{ a }}</li>
					</ul>
				</div>
				<h5>Comment</h5>
				<blockquote class="">
					{{ comment }}
				</blockquote>
			</section>
		</Modal>
	</section>
</template>

<script>
	import {mapGetters} from 'vuex';

	export default {
		name: "PatientRecordsDirectory",
		activated () {
			const {query: {type}, params} = this.$route;
			this.getPatientRecord().then(({data: {data}}) => {
				this.records = data.map(e => {
					e.issuer = this.personalify(e.issuer);
					return e;
				})
			}).catch((Error) => {
				console.log('PatientRecordsDirectory', Error, 'Error Fetching The Patient\'s Record');
				this.$router.replace({name: 'patient-profile', params});
			});	
		},
		data() {return {
			records: [],
			current: {data: {}},
			showRecordModal: false,
		}},
		computed: {
			...mapGetters(['accountType']),
		},
		methods: {
			async getReferences(refs = []) {
				let list = refs.map((ref) => this.getPatientRecord(ref));
				return await Promise.all(list);
			},
			getComponentName() {
				return this.$parent.getComponentName();
			},
			showModal(diagnosis) {
				this.showRecordModal = true;
				this.$set(this, 'current', diagnosis);
			},
			dispense(record) {
				const {chcode} = this.$route.params;
				this.$parent.markAsDispensed(chcode, record.reference, record.data.id).then(res => {
					record.data.status = 1;
				}).catch( err => console.log('Drug Dispensation Error!', err));
			},
			async getPatientRecord(ref_no = "") {
				let {params: {chcode}, query: {type}} = this.$route;
				const provider = this.getComponentName();
				const url = `/api/${provider}/patients/${chcode}/${type}`
					// + (ref_no !== '' ? `/${ref_no}` : '')

				return await axios.get(url, {params: {type}});
			},
		}
	}
</script>
