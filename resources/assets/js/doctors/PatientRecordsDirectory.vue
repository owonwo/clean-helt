<template>
	<section>
		<section class="content">
			<div >
				{{ reference }}
			</div>
			<table v-if="$route.query.type === 'diagnosis'" class="table is-bordered is-fullwidth table-hoverable" style="font-size: smaller">
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
	import Modal from '@/components/Modal.vue'

	export default {
		components: {Modal},
		name: "PatientRecordsDirectory",
		mounted() {
			const {query: {type}, params} = this.$route;
			this.getPatientRecord().then(({data: {records}}) => {
				let references = _.map(records.data, (record) => record.reference);
				this.getReferences(references).then((all) => {
					this.record_references = _.flatten(all.map((res) => res.data.data));
				});
			}).catch((Error) => {
				console.log('PatientRecordsDirectory', Error, 'Error Fetching The Patient\'s Record');
				this.$router.back();
			});	
		},
		data() {return {
			record_references: [],
			showRecordModal: false,
		}},
		computed: {
			reference() {
				return this.$route.query.type.toUpperCase()
			}
		},
		methods: {
			async getReferences(refs = []) {
				let list = refs.map((ref) => this.getPatientRecord(ref));
				return await Promise.all(list);
			},
			getComponentName() {
				return this.$parent.getComponentName();
			},
			async getPatientRecord(ref_no = "") {
				let {params: {chcode}, query: {type}} = this.$route;
				const provider = this.getComponentName();
				const url = `/api/${provider}/patients/${chcode}/records` 
					+ (ref_no !== '' ? `/${ref_no}` : '')

				return await axios.get(url, {params: {type}});
			},
		}
	}
</script>
