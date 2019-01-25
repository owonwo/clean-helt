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
      <div 
        v-if="chcode_is_wrong" 
        class="help is-danger">Invalid CHCODE entered.</div>
      <div 
        v-if="chcode_is_valid"
        class="has-text-primary is-success">CHCODE is valid</div> 
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
      <wgInput
        v-if="chcode_is_valid"
        v-model="expiration"
        label="Expiration Date" 
        type="date"
        class="custom">
        <i slot="help">expiration date should be future.</i>
      </wgInput>
    </template>
  </section>
</template>
<style lang="scss">
  .custom {
    position: relative;
    
    input {
      text-align: right;
      border-radius: 12px;
      border: none;
      box-shadow: none;
    }

    label {
      position: absolute;
      z-index: 3;
      padding: 5px 15px;
      opacity: 0.5;
    }
  }
</style>
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
    getUrl(model) {
      if(model === 'HOSPITAL') {
        return this.endpoints[model].replace('{doctor}', this.chcode)
      } else {
        return this.endpoints[model]        
      }
    },
    isPatient() {
      return this.$props.model === 'PATIENT'
    },
    sendInvite() {
      this.isLoading = true
      const { getUrl, chcode, expiration, $props: { model } } = this
      const FORM_DATA = this.isPatient() ? {chcode, expiration} : { chcode } 

      !this.canSendRequest(chcode, model) ? (this.isLoading = false) :
      this.$http.post(getUrl(model), FORM_DATA)
        .then((res) => {
          this.reset()
          this.success_message('Your Invitation Request was Successful')
          this.$emit('success', { response: res, chcode }) 
        })
        .catch(( {response: {status, data}} ) => {
          this.isLoading = false
          status === 409 ? this.notify(data.message) :
          status !== 403 || data.errors.expiration.map(e => this.error_message(e)) 
          this.$emit('error', status === 400 ? data.message : data.errors)
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
  transform: translateX(-15px);
  transition: all .3s ease-out;
}
.control span.icon {
  pointer-events: all !important;
}
</style>
