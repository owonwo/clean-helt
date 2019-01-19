<template>
  <form 
    class="has-text-centered" 
    @submit.prevent="submit">
    <pager
      :current="page">
      <section slot="p1">
        <wgInput
          v-model="fields.first_name" 
          placeholder="First Name" 
          type="text">
          <v-helper :err="$v.fields.first_name"/>
        </wgInput>
        <wgInput
          v-model="fields.middle_name" 
          placeholder="Middle Name" 
          type="text">
          <v-helper :err="$v.fields.middle_name"/>
        </wgInput>
        <wgInput 
          v-model="fields.last_name" 
          placeholder="Last Name" 
          type="text">
          <v-helper :err="$v.fields.last_name"/>
        </wgInput> 
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
          <v-helper :err="$v.fields.gender"/>
        </div>
        <wgInput 
          v-model="fields.phone" 
          minlength="11" 
          min="0" 
          type="text" 
          placeholder="Phone Number" 
          name="phone">
          <v-helper :err="$v.fields.phone"/>
        </wgInput>              
        <button 
          type="button" 
          class="button is-submit" 
          @click.prevent="page = 1">Next</button>
      </section>
      <!-- Contact Information -->
      <section slot="p2">
        <wgInput 
          v-model="fields.email" 
          placeholder="Enter Email" 
          type="email">
          <v-helper :err="$v.fields.email"/>
        </wgInput> 

        <wgInput 
          v-model="fields.password" 
          placeholder="Password" 
          type="password">
          <v-helper :err="$v.fields.password"/>
        </wgInput>

        <transition name="fade">
          <wgInput 
            v-show="!!fields.password.length"
            v-model="fields.password_confirmation" 
            placeholder="Repeat Password" 
            type="password">
            <span 
              v-if="!$v.fields.password_confirmation.sameAs"
              class="help has-text-danger">
              Password must be identical.
            </span>
          </wgInput> 
        </transition>
        <hr>
        <wgInput 
          v-model="fields.specialization" 
          placeholder="Specialization" 
          type="text">
          <v-helper :err="$v.fields.specialization"/>
        </wgInput>

        <wgInput 
          v-model="fields.folio" 
          placeholder="Folio" 
          type="text">
          <v-helper :err="$v.fields.folio"/>
        </wgInput>

        <div class="level">
          <button 
            type="button" 
            class="button is-normal" 
            @click.prevent="page = 0">Back</button>
          <button 
            type="submit" 
            class="button is-submit"
            :class="{'is-loading': isLoading}">FINISH</button>                
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
  import { required, minLength, email, sameAs } from 'vuelidate/lib/validators'

  export default {
    name: 'RegisterDoctor',
    mixins: [registerMixin],
    data: () => ({
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
      fields: {
        folio: { required },
        gender: { required },
        email: { required, email },
        middle_name: { minLength: minLength(3) },
        phone: { required, minLength: minLength(11) },
        password: { required, minLength: minLength(6) },
        last_name: { required, minLength: minLength(2) },
        first_name: { required, minLength: minLength(2) },
        specialization: { required, minLength: minLength(5) },
        password_confirmation: { sameAs: sameAs('password') },
      }
    },
    methods: {
      canSend() {
        return !this.$v.fields.$invalid
      }
    }
  }
</script>