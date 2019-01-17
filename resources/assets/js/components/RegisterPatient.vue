<template>
  <form 
    class="has-text-centered" 
    @submit.prevent="submit">
    <pager
      :current="page">
      <!-- Personal Details -->
      <section slot="p1">
        <wgInput
          v-model="fields.email" 
          type="email" 
          placeholder="Enter Email">
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
            v-show="fields.password.length"
            v-model="fields.password_confirmation" 
            placeholder="Verify Password" 
            type="password">
            <span 
              v-if="!$v.fields.password_confirmation.sameAs" 
              class="help has-text-danger">Password must be identical</span>
          </wgInput>
        </transition>
        <hr>
        <wgInput 
          v-model="fields.first_name" 
          placeholder="First Name" 
          type="text">
          <v-helper :err="$v.fields.first_name"/>          
        </wgInput>

        <wgInput 
          v-model="fields.middle_name" 
          placeholder="Middle Name" 
          type="text"/>

        <wgInput 
          v-model="fields.last_name" 
          placeholder="Last Name" 
          type="text">
          <v-helper :err="$v.fields.last_name"/>
        </wgInput>

        <wgInput 
          v-model="fields.dob"
          title="Enter Date of Birth" 
          label="Date of birth"
          type="date">
          <v-helper :err="$v.fields.dob"/>
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
        </div>
        <wgInput 
          v-model="fields.phone" 
          min="0" 
          type="text"
          minlength="11" 
          title="Enter Phone Number"
          placeholder="Phone Number">
          <v-helper :err="$v.fields.phone"/>
        </wgInput>
        <button 
          type="submit"
          class="button is-submit">FINISH</button>
      </section>
      <section slot="p2">
        <div>
          <h3 class="title mt-30 is-4">Registration Succesful</h3>
          <p class="mb-50">You have successfully registered an account. An account verification email has been sent to your 
          email.</p>
          <a
            href="/login"
            class="button is-primary"> Login </a>
        </div>
      </section>
    </pager>
  </form>
</template>

<script>
import registerMixin from '@/Mixins/registerMixin'
import { required, minLength, sameAs, email } from 'vuelidate/lib/validators'

export default {
    name: 'RegisterPatient',
    mixins: [registerMixin],
    data: () => ({
      errors: {},
      url: '/api/patient/register', 
      fields: {
        first_name: 'Joseph', 
        last_name: 'Owonvwon',
        middle_name: 'Julius',
        password: 'Tomclancy12',
        email: 'joseph.owonwo@gmail.com',
        phone: '08035957512',
        gender: 'male'
      },
    }),
    validations: {
      fields: {
        first_name: {
          required
        },
        last_name: {
          required
        },
        email: {
          required,
          email
        },
        dob: {
          required,
        },
        phone: {
          required,
          minLength: minLength(11)
        },
        password: {
          required,
          minLength: minLength(6),
        },
        password_confirmation: {
          sameAs: sameAs('password')
        },
      }
    },
    methods: {
      /** passes only the validation has no error
        * @returns boolean
      **/
      canSend() {
        return !this.$v.fields.$invalid
      },
      handleError(err) {
        if (err.response.status === 422) {
          /*form errors*/
          const {errors} = err.response.data
          const options = { group: 'register', duration: 2000 }
          this.logErrors(errors, options)
        } else if (err.response.status === 403) {
          /*server rejection request*/
          this.info_message(`Am sorry, We can't create an 
            account at the moment, please try again later.`, { group: 'register', duration: 5000 })
        }
      }
    }
  }
</script>