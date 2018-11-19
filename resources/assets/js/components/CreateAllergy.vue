<template>
    <form @submit.prevent="create">
        <h1 class="title is-4 mb-0">Add Allergy</h1>
        <h6 class="title is-6">Fill the form to add your allergies</h6>
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
export default {
    data() {return {
        form: { allergy: '', reaction: '', last_occurance: ''},
        errors: {}
    }},
    methods: {
        create() {
            const {form, getErrors} = this;
            this.$http.post('/api/patient/record/allergy', form)
                .then(resp => this.$emit('success', resp.data.data))
                .catch(getErrors)
                .then(err => this.$emit('error', err.response.data));
        },
        getErrors(error) {
            this.errors = error.response.data.errors;
            return error;
        }
    }
}
</script>
