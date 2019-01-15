<template>
  <div id="osq-login">
    <form 
      class="has-text-centered" 
      @submit.prevent="submit()">
      <img 
        class="logo" 
        src="/images/assets/logo.png" 
        alt="">
      <hgroup v-if="page !== 3">
        <h3 class="subtitle is-3 mt-30 mb-0">Sign Up</h3>
        <h5 class="menu-label mb-15">Only takes a few minutes</h5>
        <p>Already have an Account? <a 
          href="/login" 
          class="has-text-primary">Sign In</a></p>
      </hgroup>
      <br>
      <pager 
        v-if="modelIs('PATIENT')" 
        :current="page">
        <!-- Personal Details -->
        <section slot="p1">
          <div class="field">
            <input 
              v-model="field.first_name" 
              placeholder="First Name" 
              class="input" 
              type="text">
          </div>
          <div class="field">
            <input 
              v-model="field.middle_name" 
              placeholder="Middle Name" 
              class="input" 
              type="text">
          </div>
          <div class="field">
            <input 
              v-model="field.last_name" 
              placeholder="Last Name" 
              class="input" 
              type="text">
          </div>
          <div class="field">
            <input 
              v-model="field.dob" 
              type="date" 
              class="input" 
              placeholder="Date of Birth">
            <label 
              for="" 
              class="menu-label has-text-left">Date of Birth:</label>
          </div>
          <div class="field">
            <div class="select">
              <select v-model="field.gender">
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
              v-model.number="field.phone" 
              type="number"
              min="0" 
              class="input"
              minlength="11" 
              placeholder="Phone Number">
            <span 
              v-if="!!errors.phone" 
              class="help has-text-danger">{{ errors.phone[0] }}</span>
          </div>
          <hr>
          <div class="field">
            <input 
              v-model="field.email" 
              type="email" 
              placeholder="Enter Email" 
              class="input" >
            <span 
              v-if="!!errors.email" 
              class="help has-text-danger">This email `{{ field.email }}` has already been taken.</span>
          </div>
          <div class="field">
            <input 
              v-model="field.password" 
              placeholder="Password" 
              class="input" 
              type="password">
          </div>
          <button 
            type="button" 
            class="button is-submit" 
            @click.prevent="page = 1">Next</button>
        </section>
        <!-- Contact Information -->
        <section slot="p2">
          <div class="field">
            <textarea 
              v-model="field.address" 
              class="textarea" 
              placeholder="Address" 
              row="6" />
          </div>
          <div class="field">
            <select-state
              v-model="field.state" /> 
          </div>
          <div class="field">
            <select-city
              v-model="field.city"
              :state="field.state" />
          </div>
                
          <div class="field">
            <div class="select">
              <select v-model="field.country">
                <option 
                  disabled="" 
                  value="0" 
                  selected="">Select Country</option>
              </select>
            </div>
          </div>
          <div class="field">
            <div class="select">
              <select v-model="field.religion">
                <option 
                  disabled="" 
                  value="0"> Select Religion...</option>
                <option>Christainity</option>
                <option>Muslim</option>
                <option>Islam</option>
                <option value="others">Others...</option>
              </select>
            </div>
          </div>
          <wgInput 
            v-show="field.religion == 'others'"
            v-model="field.custom_religion"
            placeholder="Specify Religion"
            type="text"/>
          <div class="field">
            <div class="select">
              <select v-model="field.marital_status">
                <option 
                  disabled="" 
                  value="0"> Select Marital Status...</option>
                <option>Married</option>
                <option>Single</option>
              </select>
            </div>
          </div>
          <div 
            class="is-flex" 
            style="justify-content: space-between;">
            <button 
              type="button" 
              class="button is-normal" 
              @click.prevent="page = 0">Back</button>
            <button 
              type="button" 
              class="button is-submit" 
              @click.prevent="page = 2">Next</button>
          </div>
        </section>
        <!-- Next of Kin -->
        <section slot="p3">
          <div class="field">
            <div class="select">
              <select v-model="field.nok_relationship">
                <option 
                  disabled 
                  selected="" 
                  value="0">Relationship</option>
                <option v-for="type in relationships">{{ type }}</option>
              </select>
            </div>
          </div>
          <div class="field">
            <input 
              v-model="field.nok_name" 
              placeholder="Next of Kin" 
              class="input" 
              type="text">
          </div>
          <div class="field">
            <input 
              v-model="field.nok_email" 
              placeholder="Email" 
              class="input" 
              type="email">
          </div>                    
          <div class="field">
            <input 
              v-model.number="field.nok_phone" 
              min="0" 
              minlength="11" 
              placeholder="Phone Number" 
              class="input" 
              type="text">
          </div>                    
          <wgInput 
            v-model="field.nok_address" 
            type="textarea" 
            placeholder="Address" 
            row="2"/>
          <div class="field">
            <select-state 
              v-model="field.nok_state"/>
          </div>
          <div class="field">
            <select-city 
              v-model="field.nok_city"
              :state="field.nok_state"/>
          </div>
          <div class="field">
            <div class="select">
              <select v-model="field.nok_country">
                <option 
                  disabled="" 
                  value="0">Select Country</option>
              </select>
            </div>
          </div>
          <div 
            class="field is-flex" 
            style="justify-content: space-between;">
            <button 
              type="button" 
              class="button is-normal" 
              @click.prevent="page = 1">Back</button>
            <button 
              type="submit" 
              class="button is-submit">FINISH</button>
          </div>
        </section>

        <section slot="p4">
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
      <pager 
        v-if="modelIs('DOCTOR')" 
        :current="page">
        <section slot="p1">
          <div class="field">
            <input 
              v-model="field.first_name" 
              placeholder="First Name" 
              class="input" 
              type="text" 
              required>
          </div>
          <div class="field">
            <input 
              v-model="field.middle_name" 
              placeholder="Middle Name" 
              class="input" 
              type="text" 
              required>
          </div>
          <div class="field">
            <input 
              v-model="field.last_name" 
              placeholder="Last Name" 
              class="input" 
              type="text" 
              required>
          </div>
          <div class="field">
            <div class="select">
              <select v-model="field.gender">
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
              v-model="field.phone" 
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
              v-model="field.email" 
              placeholder="Enter Email" 
              type="email" 
              required 
              class="input" >
            <span 
              v-if="!!errors.email" 
              class="help has-text-danger">This email `{{ field.email }}` has already been taken.</span>
          </div>

          <div class="field">
            <input 
              v-model="field.password" 
              placeholder="Password" 
              class="input" 
              type="password" 
              required>
          </div>

          <hr>

          <div class="field">
            <input 
              v-model="field.specialization" 
              placeholder="Specialization" 
              class="input" 
              type="text" 
              required>
          </div>
          <div class="field">
            <input 
              v-model="field.folio" 
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
export default {
    name: 'Register',
    props: {
        model: { type: String, default: '', required: true },
    },
    data() {
        return {
            page: 0,
            field: {
                city: 0,
                state: '0'
            },
            errors: {},
            relationships: ['Brother', 'Mother', 'Father', 'Sister', 'Uncle', 'Aunty', 'Son', 'Daughter'],
            providerMap: {
                'PATIENT': { url: '/api/patient/register', name: 'patients' },
                'DOCTOR': { url: '/api/doctor/create', name: 'doctors' }
            }
        }
    },
    computed: {
        provider() {
            return this.modelIs('PATIENT') ? 'PATIENT' : 'DOCTOR'
        },
        url() {
            return this.providerMap[this.provider].url
        }
    },
    mounted() {
        const form_data = this.$props.model == 'PATIENT' 
            ? { city: '0', country: '0', gender: '0', state: '0', nok_city: '0', nok_country: '0', nok_state: '0', religion: '0', marital_status: '0', nok_relationship: '0' } 
            : { first_name: '', middle_name: '', last_name: '', email: '', password: '', gender: '0', phone: '', specialization:'', folio: ''}
        this.field =  Object.assign({}, this.field, form_data)
        this.test()
    },
    methods: {
        visit_login() {
            window.location = '/login'
        },
        modelIs(model = 'PATIENT') {
            console.assert(Object.keys(this.providerMap).includes(model), 'The Model provided is invalid!')
            return this.$props.model === model
        },
        test() {
          // this.field.religion = 'others'
          this.field.custom_religion = 'Asder'
          this.submit()
        },
        submit() {
          const field = Object.assign({}, this.field)
          this.errors = {}
          
          if (field.religion == 'others') 
            field.religion = field.custom_religion

            this.$http.post(this.url, this.field).then((res) => {
                this.page += 1
                this.fields = {}
            }).catch((err) => {
                //user already exist
                if(err.response.status === 422) {
                    this.$notify({
                        group: 'register', 
                        type: 'error',
                        duration: 2000,
                        text: 'Some fields need attention.', 
                    })
                    this.errors = err.response.data.errors
                }
                if(err.response.status === 403) 
                    this.$notify({
                        group: 'register', 
                        type: 'info',
                        duration: 5000,
                        text: 'Am sorry, We can\'t create an account at the moment, please try again later.', 
                    })
            })
        }
    }
}
</script>
