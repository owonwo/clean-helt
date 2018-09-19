<template>
	<section>
		<!-- diagnosis -->
		<section v-if="$route.query.type === 'diagnosis'" class="content">
			<div>
				Diagnosis
			</div>
			<table class="table is-bordered is-fullwidth table-hoverable" style="font-size: smaller">
				<tr>
					<th class="has-text-centered">S/N</th>
					<th>Complaint History</th>
					<th>Complaint Relationship</th>
					<th>Preview</th>
				</tr>
				<tr v-for="(record, index) of record_references" :key="index">
					<td class="has-text-centered">{{ index + 1 }}</td>
					<td>{{ record.complaint_history }}</td>
					<td>{{ record.complaint_relationship}}</td>
					<td><button @click="showRecordModal = true" class="button is-small is-primary is-outlined">View Record</button></td>
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

		<!-- <Modal class="is-note" :show="showRecordModal" :show-header="false" @closed="showRecordModal = false">
			<section v-if="$route.query.type === 'doctor'" class="content">
				<hgroup>
					<h3 class="mb-5">Diagnosis Record</h3>
					<span class="mb-5">by <b class="osq-text-primary">{{physician}}</b> at <b class="osq-text-primary">{{ time }}</b></span>
				</hgroup>
				<hr>
				<h5>Generic</h5>
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
			<section v-if="$route.query.type === 'laboratory'" class="content">
				<hgroup>
					<h3 class="mb-5">Lab Test Record</h3>
					<span class="mb-5">by <b class="osq-text-primary">Dr. Martha Kent</b> at <b class="osq-text-primary">{{ time }}</b></span>
				</hgroup>
				<hr>
				<h5></h5>
				<p style="font-size:24px">Chest X-ray for Tuberculosis showed that White  Cell Count measured 0-200 X 106/L against 0-4/L approved limit.
					CSF glucose measured 45 < mg/dL against the 60-90mg/dL
				</p>
				<h5>Comment</h5>
				<blockquote class="is-primary">
					WCC result exceeded acceptable limit. CSF below range.
				</blockquote>
			</section>
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
		</Modal> -->
	</section>
</template>

<script>
	import {mapGetters} from 'vuex';

	export default {
		name: "PatientRecordsDirectory",
		activated () {
			const {query: {type}, params} = this.$route;
			this.getPatientRecord().then(({data: {data}}) => {
				this.records = data;
			}).catch((Error) => {
				console.log('PatientRecordsDirectory', Error, 'Error Fetching The Patient\'s Record');
				this.$router.replace({name: 'patient-profile', params});
			});	
		},
		data() {return {
			records: [],
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
