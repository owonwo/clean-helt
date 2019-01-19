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
            type="password"
            @input="changeView">
            <span 
              v-if="!$v.fields.password_confirmation.sameAs" 
              class="help has-text-danger">Password must be identical</span>
          </wgInput>
        </transition>
      </section>

      <section slot="p2">
        <div>
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
                <option value="male">Others</option>
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
        </div>

        <div class="level mt-15">
          <button 
            type="button"
            class="button"
            @click="page = 0">Back</button>
          <button 
            :class="{'is-loading': isLoading}"
            type="submit"
            class="button is-submit">FINISH</button>
        </div>
      </section>

      <section slot="p3">
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
        first_name: '', 
        last_name: '',
        middle_name: '',
        password: '',
        email: '',
        phone: '',
        gender: ''
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
    computed: {
      canShowOthers() {
        const { $v } = this
        return $v.fields.password.required 
          && $v.fields.email.required
          && $v.fields.password_confirmation.sameAs
      }
    },
    methods: {
      changeView() {
        !this.canShowOthers || (this.page = 1)
      },
      canSend() {
        return !this.$v.fields.$invalid
      }
    }
  }
</script>