<template>
  <section>
    <div 
      v-if="canEdit" 
      class="field is-horizontal">
      <div class="field-body">
        <div class="field">
          <div class="control">
            <input
              v-model="form.disease"
              list="list-diseases"
              type="text"
              class="input" 
              placeholder="Disease">			
          </div>
        </div>
        <div class="field">
          <div class="control">
            <multiselect
              v-model="form.carriers"
              :multiple="true"
              :options="defaults.carriers"
              type="text"
              placeholder="Related Carrier(s)"/>
            <span class="help">If more than one, seperate by comma e.g Father, Mother, Grand Mother</span>
          </div>
        </div>
        <div 
          class="field" 
          style="flex-grow:0">
          <HoverIconButton
            :active="editing"
            :icons="['ti-upload:Update', 'ti-plus:Insert']"
            @click="addDisease"/>
        </div>
      </div>
    </div>
    
    <datalist id="list-diseases">
      <option 
        v-for="(a,index) in options.medical_history"
        :key="index"
        :value="a">{{ a }}
      </option>
    </datalist>

    <table class="table is-fullwidth">
      <tr>
        <th>Diseases</th>
        <th>
          Related Carriers
        </th>
      </tr>
      <tr 
        v-for="(entry, index) in diseases" 
        :key="index">
        <td>{{ entry.disease }}</td>
        <td>
          <span 
            v-for="(title, key) in entry.carriers"
            :key="key"
            class="tag is-primary mr-10">
            <span>{{ title }}</span>
          </span>
          <section 
            v-if="canEdit" 
            class="button-group  is-pulled-right">
            <button
              class="button has-no-motion is-small has-no-motion" 
              @click="addToForm(index)">
              <i class="ti ti-pencil-alt"/>
            </button>
            <button
              class="button has-no-motion is-small has-no-motion" 
              @click="removeDisease(index)">
              <i class="ti ti-trash"/>
            </button>
          </section>
        </td>
      </tr>
    </table>
  </section>
</template>

<style lang="scss" scoped>
	.field-body {
		.field .input {
			border: none;
      height: 40px;
			background-color: #e9e9e9;
			box-shadow: none;
		}
	}
	span.tag {
		cursor: default;
		font-size: 0.8em;
		color: rgba(black, .8);

		span.trash {
			margin-left: 5px;
			padding: 0 5px;
			border-radius: 3px;
			cursor: pointer;

			&:hover {
				background: rgba(black, .3);
			}
		}
	}
</style>

<script>
import _ from 'lodash'
import CanLock from '@/Mixins/CanLock'
import Multiselect from 'vue-multiselect'
import { mapGetters, mapState } from 'vuex'

export default {
	name: 'FamilyMedicalRecords',
  components: {Multiselect},
  mixins: [CanLock],
	data() {
		return {
			index: false,
			form: { carriers: '', disease: ''},
			defaults: {
        carriers: ['Mother', 'Father', 'Siblings', 'Grand Parents', 'Child']
			},
			endpoints: {
				create: '/api/patient/record/immunization',
				update: '/api/patient/update/{id}/immunization',
			},
		}
	},
	computed: { 
		editing() { return !_.isNumber(this.index) },
		...mapGetters('medicalRecord', {diseases: 'getDiseases'}),
    ...mapState('medicalRecord', ['options'])
	},
	mounted() {
		this.$store.dispatch('medicalRecord/FETCH_DISEASES')
	},
	methods: {
		addToForm(index) {
			this.index = +index
			this.form = _.extend({}, this.diseases[index])
			this.form.carriers = this.form.carriers.join(', ')
		},
		async done (diseases) {
			this.$store.commit('medicalRecord/set_diseases', diseases)
			this.$store.dispatch('medicalRecord/UPDATE_DISEASES')
		},
		addDisease() {
			const {form, index} = this,
				diseases = this.diseases.concat([])

			form.carriers = typeof(carriers) === 'string' 
        ? form.carriers.split(',').map(e => e.trim())
        : form.carriers

			if(_.isNumber(index)) {
				diseases[index] = form
				this.index = false
			} else {
				diseases.push(form)
			}
			this.done(diseases).then(() => {
				this.form = {}
				this.$notify({text: 'Disease added to Family History', type: 'success'})
			})
		},
		removeDisease(index) {
			const diseases = this.diseases.map((entry, i) => {
				if(i === index) 
					this.$store.dispatch('medicalRecord/DELETE_DISEASE', entry)
				return entry
			}).filter((e,i) => i !== index)

			this.done(diseases)
		},
	}
}
</script>