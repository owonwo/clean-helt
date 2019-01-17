<template>
  <form 
      class="has-text-centered" 
      @submit.prevent="submit">
    <pager
      :current="page">
      <section slot="p1">
        <div class="field">
          <input 
            v-model="fields.first_name" 
            placeholder="First Name" 
            class="input" 
            type="text" 
            required>
        </div>
        <div class="field">
          <input 
            v-model="fields.middle_name" 
            placeholder="Middle Name" 
            class="input" 
            type="text" 
            required>
        </div>
        <div class="field">
          <input 
            v-model="fields.last_name" 
            placeholder="Last Name" 
            class="input" 
            type="text" 
            required>
        </div>
        <div class="field">
          <div class="select">
            <select v-model="fields.gender">
              <option 
                disabled 
                value="0" 
                selected="">Select Gender...</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
        </div>
        <div class="field">
          <input 
            v-model="fields.phone" 
            minlength="11" 
            min="0" 
            placeholder="Phone Number" 
            class="input" 
            type="text" 
            name="phone">
          <span 
            v-if="!!errors.phone" 
            class="help has-text-danger">{{ errors.phone[0] }}</span>
        </div>                  
        <button 
          type="button" 
          class="button is-submit" 
          @click.prevent="page = 1">Next</button>
      </section>
      <!-- Contact Information -->
      <section slot="p2">
        <div class="field">
          <input 
            v-model="fields.email" 
            placeholder="Enter Email" 
            type="email" 
            required 
            class="input" >
          <span 
            v-if="!!errors.email" 
            class="help has-text-danger">This email `{{ fields.email }}` has already been taken.</span>
        </div>

        <div class="field">
          <input 
            v-model="fields.password" 
            placeholder="Password" 
            class="input" 
            type="password" 
            required>
        </div>

        <hr>

        <div class="field">
          <input 
            v-model="fields.specialization" 
            placeholder="Specialization" 
            class="input" 
            type="text" 
            required>
        </div>
        <div class="field">
          <input 
            v-model="fields.folio" 
            placeholder="Folio" 
            class="input" 
            type="text">
        </div>

        <div 
          class="field is-flex" 
          style="justify-content: space-between;">
          <button 
            type="button" 
            class="button is-normal" 
            @click.prevent="page = 0">Back</button>
          <button 
            type="submit" 
            class="button is-submit">FINISH</button>                
        </div>
      </section>

      <section slot="p3">
        <div>
          <h3 class="title mt-30 is-4">Registration Succesful</h3>
          <p class="mb-50">You have successfully registered an account. An account verification email has been sent to your 
          email.</p>
          <button 
            class="button is-primary" 
            @click="visit_login">Login</button>
        </div>
      </section>
    </pager>
  </form>
</template>

<script>
  import registerMixin from '@/Mixins/registerMixin'
  import { required, minLength, between } from 'vuelidate'

  export default {
    name: 'RegisterDoctor',
    mixins: [registerMixin],
    data: () => ({
      errors: {},
      url: '/api/doctor/create',
      fields: {
        first_name: '', middle_name: '', 
        last_name: '', email: '', 
        city: '0', state: '0',
        password: '', gender: '0', 
        phone: '', specialization:'', 
        folio: '',
      },
    }),
    validations: {
      // fields: {
      //   first_name: {
      //     required,
      //     minLength: minLength(4)
      //   },
      //   last_name: {
      //     required,
      //     minLength: minLength(4)
      //     // between: between(20, 30)
      //   }
      // }
    }
  }
</script>