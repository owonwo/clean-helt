<template>
    <section class="card">
        <div class="card-header"><span class="card-header-title"> Add A Hospital</span></div>
        <div class="card-content">
            <div class="field">
                <div class="control has-icons-left">
                    <span class="icon is-left"><i class="ti ti-search"></i></span>
                    <input type="text" class="input" v-model="chcode" placeholder="Enter Hospital CHCODE e.g CHH-300958483" />
                </div>
                <div v-if="chcode_is_wrong" class="help is-danger">Invalid CHCODE entered.</div>
                <div v-if="chcode.length > 0 && !chcode_is_wrong" class="help is-success">You have entered a valid CHCODE</div>
            </div>
            <button @click="sendInvite" :class="{'is-loading': isLoading}" class="button is-rounded is-primary">Send Request <i class="ti ti-angle-right"></i></button>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        model: { type: String, default: '', required: true },
    },
    data() {
        return {
            isLoading: false,
            endpoints: Object.freeze({
                DOCTOR: '/api/doctor/add-hospital',
            }),
            models: ['DOCTOR', 'PATIENT', 'HOSPITAL'],
            chcode: "",
        }
    },
    computed: {
        chcode_is_wrong() {
            return this.chcode.length > 0 ?
                !this.testChCode(this.chcode) : false
        }
    },
    methods: {
        notify (message = "Testing Message", type = "info") {
            this.$notify({
                type: type,
                text: message,
                duration: 2000,
            });
        },
        reset() {
            this.isLoading = false
            this.chcode = ""
        },
        canSendRequest(chcode, model) {
            return this.models.includes(model) && 
                this.testChCode(chcode)
        },
        sendInvite() {
            this.isLoading = true;
            let { chcode, $props: { model } } = this;
            const url = this.endpoints[model];
                !this.canSendRequest(chcode, model) ? (this.isLoading = false) :
                this.$http.post(url, { chcode }).then((res) => {
                    this.reset();
                    this.notify('Your Invitation Request was Successful', 'success');
                    this.$emit('success', { response: res, chcode });
                }).catch(err => {
                    let {response} = err;
                    this.reset();
                    response.status === 409 ? this.notify(response.data.message) :
                    this.notify('There was an error sending request', 'error');
                    this.$emit('error', err);
                });
        },
    }
}
</script>
