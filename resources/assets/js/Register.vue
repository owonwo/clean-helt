<template>
  <div id="osq-login">
    <section>
      <img 
        class="logo" 
        src="/images/assets/logo.png" 
        alt="">
      <hgroup 
        v-if="isLastPage"
        class="has-text-centered">
        <h3 class="subtitle is-3 mt-30 mb-0">Sign Up</h3>
        <h5 class="menu-label mb-15">Only takes a few minutes</h5>
        <p>Already have an Account?  
          <a 
            href="/login" 
            class="has-text-primary">Sign In</a>
        </p>
      </hgroup>
      <br>
      <RegisterDoctor 
        v-if="modelIs('DOCTOR')"
        ref="doctorForm"
        @success="() => isLastPage = false"/>
      <RegisterPatient 
        v-if="modelIs('PATIENT')" 
        ref="patientForm"
        @success="() => isLastPage = false"/>
    </section> 
  </div>
</template>

<style>
#page-slider {
  transition: all .7s cubic-bezier(0.52, 0.32, 0, 0.96) !important;
}
#page-slider .page {
  padding: 0px 10px 10px 10px;
}
</style>
<script>
import RegisterDoctor from '@/components/RegisterDoctor'
import RegisterPatient from '@/components/RegisterPatient'

export default {
  name: 'Register',
  components: { RegisterPatient, RegisterDoctor },
  props: {
    model: { type: String, default: '', required: true },
  },
  data: () => ({
    isLastPage: true,
  }),
  mounted() {
    document.title = 'Register - CleanHelt'
  },
  methods: {
    modelIs(model) {
      return this.$props.model  === model
    }
  }
}
</script>
