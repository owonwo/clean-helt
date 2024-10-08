<template>
  <section>
    <!-- doctors section -->
    <section 
      class="mb-30" 
      aria-labelled="section-for-doctors">
      <button 
        v-if="canEdit"
        class="button is-primary"
        @click="show = !show">
        <i class="ti ti-plus icon"/>
        <span>Add Record</span>
      </button>
      <button 
        class="button is-primary"
        @click="FETCH_MEDICAL_CHECKUPS">
        <span>Refresh</span>
      </button>
    </section>

    <section aria-labelled="section-for-both-patients-doctors">
      <section 
        v-for="(record, index) in checkups"
        :key="index"
        class="card is-checkup">
        <section class="level checkup-header">
          <a 
            class="title mb-0 is-5"
            @click.prevent="record.toggleEdit">{{ record.title }}</a>
          <div>
            <a 
              :href="record.report" 
              :download="record.title">
              <button 
                ghost 
                class="button is-small is-outlined is-rounded">
                <i class="ti icon ti-download"/>
                <span>Download</span>
              </button>
            </a>
            <button 
              ghost 
              class="button is-small is-outlined is-rounded">
              <i class="ti icon ti-eye"/>
              <span>Preview</span>
            </button>
          </div>
        </section>
        <article class="checkup-description">
          <p v-if="record.isEditing">{{ record.summary | truncate(50) }}</p>            
        </article>
      </section>
    </section>

    <modal 
      ref="modal"
      :show="show"
      @closed="() => show = false">
      <span slot="modal-title">Create a Medical Checkup Record</span>
      <form @submit.prevent="submit">
        <wgInput 
          v-model="form.title"
          type="text"
          label="Report Title"
          placeholder="Check for Hepitatis #3"/>
        <wgInput 
          v-model="form.checkup_date"
          label="Checkup Date"
          type="date"/>
        <wgInput 
          v-model="form.report"
          label="Report File"
          type="file"
          @change="extractfile">
          <p slot="help">download Medical Checkup <a :href="template_file" download>Template</a>.</p>
        </wgInput>
        <wgInput
          v-model="form.summary"
          label="Summary"
          type="textarea"
          rows="3"/>
        <button class="button is-primary">Upload Checkup</button>
      </form>
    </modal>
  </section>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import CanLock from '@/Mixins/CanLock'

  export default {
    name: 'MedicalCheckup',
    mixins: [ CanLock ],
    data() {return {
      show: false,
      template_file: '',
      form: {
        title: '',
        report: '',
        summary: '',
        checkup_date: '',
      }
    }},
    computed: {
      ...mapState('medicalRecord', ['checkups'])
    },
    mounted() {
      this.FETCH_MEDICAL_CHECKUPS()
    },
    methods: {
      extractfile(event) {
        this.form.report = event.target.files[0]
      },
      resetForm() {
        this.form = {}
        this.$refs.modal.hide()
      },
      submit() {
        const {compose, resetForm, make_form_data, FETCH_MEDICAL_CHECKUPS, form} = this
        compose(this.CREATE_MEDICAL_CHECKUP, make_form_data)(form)
          .then(({message}) => compose(FETCH_MEDICAL_CHECKUPS, resetForm, this.success_message)(message))
          .catch(errs => this.logErrors(errs))
      },
      ...mapActions('medicalRecord', [
        'FETCH_MEDICAL_CHECKUPS',
        'CREATE_MEDICAL_CHECKUP'
        ])
    }
  }
</script>