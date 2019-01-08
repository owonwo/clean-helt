<template>
  <form @submit.prevent="create">
    <h1 class="title is-4 mb-0">Add Immunization</h1>
    <h6 class="title is-6">Fill the form to add Immunization Info.</h6>
    <div class="field">
      <div class="control">
        <label for="">Immunization Title</label>
        <input 
          v-model="form.immunization_title" 
          placeholder="Title" 
          type="text" 	
          class="input is-error">
      </div>
    </div>
    <div class="field">
      <label for="">Age</label>
      <input 
        v-model="form.age" 
        type="number" 
        class="input" >
    </div>
    <div class="field">
      <div class="control">
        <label for="">Date</label>
        <input 
          v-model="form.date_of_immunization" 
          type="date" 
          class="input">
      </div>
    </div>
    <button class="button is-primary">Add</button>
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