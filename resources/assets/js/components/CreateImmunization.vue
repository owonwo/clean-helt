<template>
  <form @submit.prevent="create">
    <h1 class="title is-4 mb-0">Add Immunization</h1>
    <h6 class="title is-6">Fill the form to add Immunization Info.</h6>
    <wgInput
      v-model="form.immunization_title" 
      label="Immunization Title"
      placeholder="Title" 
      type="text"/>
    <wgInput 
      v-model="form.age" 
      label="Age"
      type="number"/>
    <wgInput
      v-model="form.date_of_immunization"
      label="Date of Immunization" 
      type="date" />
    <button class="button is-primary">
      <span v-text="!form.id ? `Add`: `Update`"/>
    </button>
  </form>
</template>

<script>
import MedicalRecord from '@/Mixins/MedicalRecord'

export default {
  name: 'CreateImmunization', 
  mixins: [MedicalRecord],
  data() {
    return {
      form: { immunization_title: '', age: '', date_of_immunization: '' }
    }
  },
}
</script> 