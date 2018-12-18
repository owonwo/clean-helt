<template>
  <form @submit.prevent="create">
    <h1 class="title is-4 mb-0">Allergies</h1>
    <h6 class="title is-6">Fill the form to add/edit allergy</h6>
    <div class="field">
      <input 
        v-model="form.allergy" 
        placeholder="Allergy" 
        type="text" 
        class="input is-error">
    </div>
    <div class="field">
      <textarea 
        v-model="form.reaction" 
        placeholder="Reaction" 
        class="textarea"/>
    </div>
    <div class="field">
      <input 
        v-model="form.last_occurance" 
        placeholder="" 
        type="date" 
        class="input">
    </div>
    <button class="button is-primary">Create</button>
  </form>
</template>

<script>
import MedicalRecord from '@/Mixins/MedicalRecord'

export default {
    mixins: [MedicalRecord],
    data() {return {
        form: { allergy: '', reaction: '', last_occurance: ''},
    }},
    methods: {}
}
</script>
