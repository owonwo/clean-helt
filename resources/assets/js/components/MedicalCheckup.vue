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
              <button ghost class="button is-small is-outlined is-rounded">
                <i class="ti icon ti-download"/>
                <span>Download</span>
              </button>
            </a>
            <button ghost class="button is-small is-outlined is-rounded">
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
      <h1 class="title is-4">Add Medical Checkup Record</h1>
      <form @submit.prevent="submit">
        <label for="">Report Title</label>
        <form-input 
          v-model="form.title"
          type="text"
          placeholder="Check for Hepitatis #3"
          @value="(v) => form.title = v"/>
        <label for="">Checkup Date</label>
        <form-input 
          v-model="form.checkup_date"
          type="date" 
          @value="(v) => form.checkup_date = v"/>
        <label for="">Record File</label>
        <form-input 
          v-model="form.report"
          type="file" 
          @change="extractfile"/>
        <div class="field">
          <label for="">Summary</label>
          <textarea 
            v-model="form.summary"
            rows="3" 
            class="textarea"/>
          <span class="is-small"/>
        </div>
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