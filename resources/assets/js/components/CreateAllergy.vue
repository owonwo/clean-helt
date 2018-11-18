<template>
    <form @submit.prevent="create">
        <h1 class="title is-4 mb-0">Add Allergy</h1>
        <h6 class="title is-6">Fill the form to add your allergies</h6>
        <div class="field">
            <input placeholder="Allergy" v-model="form.allergy" type="text" class="input">
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
        // form: { allergy: '', reaction: '', last_occurance: ''}
        form: {"allergy":"Mighrian","last_occurance":"2018-11-21","reaction":"Fall off a building at a construction site"}
    }},
    methods: {
        create() {
            this.$emit('error', 'Not Working!');
            // const {form} = this;
            // this.$http.post('/api/patient/record/allergy', form)
            //     .then(resp => this.$emit('success', resp.data.data))
            //     .catch(err => this.$emit('error', err.response.data));
        }
    }
}
</script>
