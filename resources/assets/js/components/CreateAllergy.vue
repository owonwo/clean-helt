<template>
    <form @submit.prevent="create">
        <h1 class="title is-4 mb-0">Allergies</h1>
        <h6 class="title is-6">Fill the form to add/edit allergy</h6>
        <div class="field">
            <input placeholder="Allergy" v-model="form.allergy" type="text" class="input is-error">
        </div>
        <div class="field">
            <textarea placeholder="Reaction" v-model="form.reaction" class="textarea"></textarea>
        </div>
        <div class="field">
            <input placeholder="" v-model="form.last_occurance" type="date" class="input">
        </div>
        <button class="button is-primary">Create</button>
    </form>
</template>

<script>
import MedicalRecord from '@/Mixins/MedicalRecord'

export default {
    mixins: [MedicalRecord],
    data() {return {
        endpoints: {
            create: '/api/patient/record/allergy',
            update: '/api/patient/update/{id}/allergy',
        },
        form: { allergy: '', reaction: '', last_occurance: ''},
    }},
    methods: {}
}
</script>
