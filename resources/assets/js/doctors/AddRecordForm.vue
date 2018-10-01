<template>
	<section class="">
		<form id="add-record" @submit.prevent="">
			<!-- HEADER -->
			<section id="header" style="grid-area: header">
				<h1 class="title is-4 mb-0">Add Record</h1>
				<button class="button is-success" @click="submit()" type="button">
					<span class="icon"><i class="ti ti-save"></i></span>
					<span>Save</span>
				</button>				
			</section>
			<!-- symptoms -->
			<v-scrollbar class="field card card-content" style="grid-area: symptoms">
				<div class="menu-label">SYMPTOMS</div>
				<div class="card-bottom-bar">
					<input type="text" class="input" v-model="temps.symptom" tabindex="43"> 
					<button type="button" class="md-btn-circle is-pulled-right" tabindex="44" @click="addSymptom">
						<i class="ti ti-plus"></i>
					</button>
				</div>
				<div class="menu">
					<div v-show="symptom.visible" v-for="(symptom, index) in reverseSymptoms"
						:key="index" class="menu-list">
						<a @click.prevent="symptom.visible = false" href="#">
							{{ symptom.text }} <i class="is-pulled-right ti ti-trash"></i>
						</a>
					</div>
				</div>
			</v-scrollbar>

			<!-- extras -->
			<v-scrollbar class="field card card-content" style="grid-area: questions">
				<div class="menu-label">QUESTIONS</div>
				<button @click="addRecord('extra')" class="md-btn-circle is-pulled-right"><i class="ti ti-plus"></i></button>
				<div class="menu">
					<div v-if="entry.visible" class="menu-list" v-for="(entry, key, index) in fields.extras">
						<div v-if="entry.edit">
							<input type="text" v-model="entry.question" placeholder="Question" class="input is-inline-block">
							<input type="text" v-model="entry.answer" placeholder="Answer" class="input is-inline-block">
						</div>
						<div v-else>
							<div><b>{{ entry.question }}</b></div>
							<div class="has-text-primary">{{ entry.answer }}</div>
						</div>
						<button @click="entry.edit = !entry.edit" class="button is-outlined is-normal">
							<i class="ti" :class="[ entry.edit ? 'ti-save' : 'ti-pencil']"></i>
						</button>
						<button @click="entry.visible = false" class="button is-outlined is-normal">
							<i class="ti ti-trash"></i>
						</button>

					</div>
				</div>
			</v-scrollbar>

			<!-- Prescription -->
			<v-scrollbar class="field card card-content" style="grid-area: prescription">
				<!-- drugs quantity -->
				<label for="" class="menu-label">Prescriptions</label>
				<button @click="addRecord('prescript')" class="md-btn-circle is-pulled-right"><i class="ti ti-plus"></i></button>
				<!-- drug frequency -->
				<div class="menu">
					<div v-if="prescript.visible" class="menu-list" v-for="(prescript, key, index) in fields.prescriptions">
						<div v-if="prescript.edit">
							<input type="text" placeholder="Medicine" v-model="prescript.name" class="input is-inline-block">
							<input type="text" placeholder="Quantity" v-model="prescript.quantity" class="input is-inline-block">
							<input type="text" placeholder="Frequency" v-model="prescript.frequency" class="input is-inline-block">
						</div>
						<div v-else>
							<div><b>{{ prescript.name }}</b> </div>
							<div>Frequency: <b class="has-text-primary">{{ prescript.frequency }}</b></div>
							<div>Quantity: {{ prescript.quantity }}</div>
						</div>
						<!--  					
						<div>
							<b>{{ prescript.name }}</b> to be taken 
							{{ prescript.quantity }} every time 
							<b class="has-text-primary">{{ prescript.frequency }}</b> days.
						</div>-->
						<button @click="prescript.edit = !prescript.edit" class="button is-outlined is-normal">
							<i class="ti" :class="[ prescript.edit ? 'ti-save' : 'ti-pencil']"></i>
						</button>
						<button @click="prescript.visible = false" class="button is-outlined is-normal">
							<i class="ti ti-trash"></i>
						</button>
					</div>
				</div>
			</v-scrollbar>

			<!-- Test -->
			<v-scrollbar class="field card card-content" style="grid-area: lab_test">
				<!-- test name -->
				<label for="" class="field-label">Add Labaroratory Test</label>
				<button @click="addRecord('test')" class="md-btn-circle is-pulled-right"><i class="ti ti-plus"></i></button>
				<!-- test frequency -->
				<div class="menu">
					<div class="menu-label">LAB TESTS</div>
					<div v-if="test.visible" class="menu-list" v-for="(test, key, index) in fields.tests">
						<div v-if="test.edit">
							<input type="text" placeholder="Enter Test Name" v-model="test.name" class="input">
							<textarea class="textarea" placeholder="Expected Result" v-model="test.result"></textarea>
							<textarea class="textarea" placeholder="Write Lab Test Description" type="text" v-model="test.description">
							</textarea>
						</div>
						<div v-else>
							<div><b>{{ test.name }}</b></div>
							<div>DESCRIPTION: {{ test.description | truncate(80) }}</div>
							<div>RESULT: {{ test.result | truncate(50) }}</div>
						</div>
						<button @click="test.edit = !test.edit" class="button is-outlined is-normal">
							<i class="ti" :class="[ test.edit ? 'ti-save' : 'ti-pencil']"></i>
						</button>
						<button @click="test.visible = false" class="button is-outlined is-normal">
							<i class="ti ti-trash"></i>
						</button>
					</div>
				</div>
			</v-scrollbar>

			<!-- conclusion -->
			<div class="field card card-content" style="grid-area: conclusion">
				<!-- patient condition -->
				<div class="field" style="grid-area: condition">
					<div>
						<label for="" class="menu-label">Patient Condition</label>
					</div>
					<div class="has-text-left">
						Fair
						<input type="radio" class="ml-10" name="patient_condition" value="1" @click="fields.patient_condition = 1"> <br>			
						Critical
						<input type="radio" class="ml-10" name="patient_condition" value="1" @click="fields.patient_condition = 2">		 <br>				
						Severe
						<input type="radio" class="ml-10" name="patient_condition" value="1" @click="fields.patient_condition = 3">		 <br>				
					</div>
					<small class="help">The Severity of the Patient's Condition</small>
				</div>
				
				<label class="menu-label">Conclusion</label>
				<textarea style="width: 100%; max-width:100%" v-model="fields.comments" rows="10"></textarea>
			</div>
		</form>
	</section>
</template>

<script>
	const data = {editable: true, edit: false, visible: true,} 
	const build = (a) => {return {
		make: () => Object.assign({}, a, {edit: true}),
		create: () => Object.assign({}, a)
	}}
	const questionFactory = (object = {}) => {
		const question = Object.assign(data,{questions: '', answer: ''}, object)
		return build(question);
	}
	const testFactory = (object = {}) => {
		const test = Object.assign(data, {name: '', description: '', result: ''}, object)
		return build(test);
	}
	const prescriptFactory = (object = {}) => {
		const prescript = Object.assign(data,{name: '', frequency: ''}, object)
		return build(prescript);
	}

	export default {
		name: 'AddRecordForm',
		mounted() {
		},
		data() {return {
			fields: {
				patient_condition: 0,
				symptoms: [],
				extras: [],
				prescriptions: [],
				tests: [],
				comments: '',
				status: false,
				taker: 0,
			},
			temps: {symptom: ""}
		}},
		computed: {
			reverseSymptoms() { return this.fields.symptoms.reverse() }
		},
		methods: {
			addSymptom(event) {
				let {symptom: text} = this.temps;
				let symptom = Object.assign({visible: true}, {text});
				if(!_.isUndefined(symptom) && !_.isEmpty(symptom)) 	
				this.fields.symptoms.push(symptom) && (this.temps.symptom = '');
			},
			addRecord(type = '') {
				(type == 'prescript') ? this.fields.prescriptions.push(prescriptFactory().make())
				: (type == 'extra') ? this.fields.extras.push(questionFactory().make()) 
				: (type !== 'test') || this.fields.tests.push(questionFactory().make()) ;
			},
			submit() {
				let {chcode} = this.$route.params,
					data = Object.assign({}, this.fields);
					//filter symptoms
					data.extras = data.extras.filter(e => e.visible == true).map(e => {
						return {question: e.question, answer: e.answer}
					}).join();
					data.symptoms = data.symptoms.filter(e => e.visible == true).map(e => e.text).join();
					//filter tests
					data.tests = data.tests.filter(e => (e.name.trim().length > 0) && e.visible == true )
					.map(e => { return {
						test_name: e.name,
						description: e.description, 
						result: e.result}
					});

				this.$http.post(`/api/doctor/patients/${chcode}/diagnose`, data).then((res) => {
					this.$notify({text: 'Record added successfully', type: 'success'});
					this.$router.back();
				}).catch((err) => {
					this.$notify({text: err.response.data.message, type: 'error'});
				})
			},
		}
	}
</script>
