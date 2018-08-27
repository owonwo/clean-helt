<template>
	<section>
		<section class="content">
			<table class="table is-bordered is-fullwidth table-hoverable" style="font-size: smaller">
				<tr>
					<th class="has-text-centered">S/N</th>
					<th v-for="(column, index) in table">{{ index }}</th>
					<th>Preview</th>
				</tr>
				<tr v-for="a in 12">
					<td class="has-text-centered">{{ a }}</td>
					<td v-for="(column, index) in table">{{ column }}</td>
					<td><button @click="showRecordModal = true" class="button is-small is-primary is-outlined">View Record</button></td>
				</tr>
			</table>
		</section>

		<Modal class="is-note" :show="showRecordModal" :show-header="false" @closed="showRecordModal = false">
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
		</Modal>
	</section>
</template>

<script>
	import Modal from '@/components/Modal.vue'

	export default {
		components: {Modal},
		name: "PatientRecordsDirectory",
		mounted() {
			const {type} = this.$route.query;
			this.table = type === "doctor" ? {
				'Date of Diagnosis': "2018/05/30",
				'Practitioner': 'Dr. Bob Dollas', 
				'Prescription': true,
				'Reason for appointment': 'I had a simple migrin with my add.',
			} : type === 'pharmacy' ? {
				'Pharmacy': 'Sicone Pharmacy',
				'Prescription Date': '2018/01/08',
				'Dispense Date': '2018/03/03',
				'Physician' : 'Dr. Luke Gray',
			 } : type == "laboratory" ? {
			 	'Practitioner' : 'Dr. Martha Kent',
			 	'Test Date': '2018/12/05',
			 	'Type': 'Genotype',
			 } : {};
		},
		data() {return {
			table: {columns : []},
			showRecordModal: false,
			prescriptions: ['Pandol', 'B Syrup', 'Codeine'],
			dispensed: ['Pandol', 'B Syrup'],
			comment: `Panadol and B Syrup was available, But we don't have Codeine at the moment.`,
			physician: "Dr. Luke Gray",
			time: "2018/03/03 00:07"
		}},
		methods: {
		}
	}
</script>
