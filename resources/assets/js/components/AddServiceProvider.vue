<template>
  <section>
    <template v-if="osqStyle !== 'fullwidth'">
      <div class="field">
        <div class="control has-icons-left">
          <span class="icon is-left"><i class="ti ti-search"/></span>
          <input 
            v-model="chcode" 
            type="text" 
            class="input" 
            placeholder="Enter CHCODE" >
        </div>
        <div 
          v-if="chcode_is_wrong" 
          class="help is-danger">Invalid CHCODE entered.</div>
        <div 
          v-if="chcode.length > 0 && !chcode_is_wrong" 
          class="help is-success">You have entered a valid CHCODE</div>
      </div>
      <button 
        :class="{'is-loading': isLoading}" 
        class="button is-rounded is-primary" 
        @click="sendInvite">
        Send Request <i class="ti ti-angle-right"/>
      </button>
    </template>
    <template v-else> 
      <div class="field has-addons">
        <p class="control is-expanded has-icons-left has-icons-right has-shadow">
          <span class="is-left icon"><i class="osf osf-search"/></span>
          <input 
            v-model="chcode" 
            type="text" 
            class="input has-text-centered" 
            name="chcode" 
            style="padding-left:calc(0.625em - 1px);border-radius: 30px" 
            placeholder="Enter CHCode">
          <span class="is-right icon">
            <button 
              :class="{'is-loading': isLoading}" 
              class="button is-primary"
              @click="sendInvite"><i class="ti ti-arrow-right"/></button>
          </span>
        </p>
      </div>
      <div 
        v-if="chcode_is_wrong" 
        class="help is-danger">Invalid CHCODE entered.</div>
      <div 
        v-if="chcode_is_valid" 
        class="field">
        <input 
          v-model="expiration" 
          type="date" 
          class="input is-rounded has-shadow is-expanded">
      </div>
      <div 
        v-if="chcode_is_valid" 
        class="help is-success">You have entered a valid CHCODE</div> 
    </template>
  </section>
</template>

<script>
export default {
    props: {
        model: { type: String, default: '', required: true },
        osqStyle: { type: String, default: '', required: false },
    },
    data() {
        return {
            isLoading: false,
            endpoints: Object.freeze({
                DOCTOR: '/api/doctor/add-hospital',
                HOSPITAL: '/api/hospital/doctors/{doctor}/invite',
                PATIENT: '/api/patient/profile/shares',
            }),
            models: ['DOCTOR', 'PATIENT', 'HOSPITAL'],
            chcode: '',
            expiration: '',
        }
    },
    computed: {
        chcode_is_valid() {
            return this.chcode.length > 0 && !this.chcode_is_wrong
        },
        chcode_is_wrong() {
            return this.chcode.length > 0 ?
                !this.testChCode(this.chcode.trim()) : false
        }
    },
    methods: {
        notify (message = 'Testing Message', type = 'info') {
            this.$notify({
                type: type,
                text: message,
                duration: 2000,
            })
        },
        reset() {
            this.isLoading = false
            this.chcode = ''
        },
        canSendRequest(chcode, model) {
            return this.models.includes(model) && 
                this.testChCode(chcode)
        },
        sendInvite() {
            this.isLoading = true
            let { chcode, expiration, $props: { model } } = this
            const FORM_DATA = model === 'PATIENT' ? {chcode, expiration} : { chcode } 
            let url = this.endpoints[model]
                if(model === 'HOSPITAL') url = url.replace('{doctor}', chcode)

                !this.canSendRequest(chcode, model) ? (this.isLoading = false) :
                this.$http.post(url, FORM_DATA).then((res) => {
                    this.reset()
                    this.success_message('Your Invitation Request was Successful')
                    this.$emit('success', { response: res, chcode })
                }).catch(( {response: {status, data}} ) => {
                    this.isLoading = false
                    status === 409 ? this.notify(data.message) :
                    status !== 403 || data.errors.expiration.map(e => this.error_message(e)) 
                    this.$emit('error', data.errors)
                })
        },
    }
}
</script>
<style scoped>
.control span.icon .button {
    border-radius: 30px !important;
    min-width: 55px;
    text-align: center;
    height: 80%;
    transform: translateX(0px);
    transition: all .3s ease-out;
}
.control span.icon {
    pointer-events: all !important;
}
.control span.icon .button:hover,
.control span.icon .button:focus
 {
    transform: translateX(-15px);
}
</style>
