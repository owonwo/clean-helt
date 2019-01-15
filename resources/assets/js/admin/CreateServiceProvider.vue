<template>
  <section class="content">
    <div 
      class="content-top-bar is-flex" 
      style="justify-content: space-between">
      <span>Create a Service Provider</span>
      <div class="buttons">
        <button 
          v-select-form="'hospital'" 
          class="button is-normal is-rounded is-primary">
          <i class="osf icon osf-hospital"/> <span>Hospital</span>
        </button>
        <button 
          v-select-form="'pharmacy'" 
          class="button is-normal is-rounded">
          <i class="osf icon osf-pharmacy"/> <span>Pharmacy</span>
        </button>
        <button 
          v-select-form="'laboratory'" 
          class="button is-normal is-rounded">
          <i class="osf icon osf-lab"/> <span>Laboratory</span>
        </button>
      </div>
    </div>
    <div id="create-user-form">
      <section>
        <div>
          <div class="menu-label">{{ model | ucfirst }} Information</div>
          <div class="field">
            <input 
              v-model="forms.generic.name" 
              type="text" 
              class="input" 
              placeholder="Name">
          </div>
          <div class="field">
            <input 
              v-model="forms.generic.email" 
              type="text" 
              class="input" 
              placeholder="Email">
          </div>
          <div class="field">
            <input 
              v-model="forms.generic.phone" 
              type="text" 
              class="input" 
              placeholder="Telephone">
          </div>
          <div class="field">
            <div class="select is-fullwidth">
              <select 
                v-model="forms.generic.country" 
                class="input">
                <option 
                  value="0" 
                  selected="">Select Country...</option>
                <option>Nigeria</option>
              </select>
            </div>
          </div>
          <div 
            v-show="forms.generic.country !== 0" 
            class="field">
            <select-state 
              v-model="forms.generic.state" 
              class="is-fullwidth"/> 
          </div>
          <div 
            v-show="forms.generic.state !== 0" 
            class="field">
            <select-city 
              v-model="forms.generic.city"
              :state="`${forms.generic.state}`" 
              class="is-fullwidth"/>
          </div>
          <div class="field">
            <textarea 
              v-model="forms.generic.address" 
              class="textarea" 
              placeholder="Address"/>
          </div>
          <div 
            v-if="model !== 'laboratory'" 
            class="field">
            <input 
              v-model="forms.generic.services" 
              type="text" 
              class="input" 
              placeholder="Services">
            <div class="help is-bold"><b>Seperate by comma (,)</b></div>
          </div>
          <div 
            v-else 
            class="field">
            <input 
              v-model="forms.laboratory.offers" 
              type="text" 
              class="input" 
              placeholder="Offers">
            <div class="help is-bold"><b>Seperate by comma (,)</b></div>                    
          </div>
          <div class="field">
            <input 
              v-model="forms.hospital.website" 
              type="text" 
              class="input" 
              placeholder="https://hospital.care">
            <div class="help is-bold">Service provider website if any.</div>
          </div>
          <button 
            :class="{'is-loading': loading }" 
            class="button is-primary" 
            @click="register">
            Register
          </button>
        </div>
      </section>
      <!-- directors form -->
      <section>
        <div class="menu-label">Directors Information</div>
        <div 
          v-if="is('hospital')" 
          class="field">
          <input 
            v-model="forms.hospital.director_mdcn" 
            type="text" 
            class="input" 
            placeholder="Director MDCN">
        </div>
        <div 
          v-if="is('laboratory')" 
          class="field">
          <input 
            v-model="forms.laboratory.lab_owner" 
            type="text" 
            class="input" 
            placeholder="Owner's Name">
        </div>                
        <!-- pharmacy chief information -->
        <div v-show="is('pharmacy')">
          <div class="field">
            <input 
              v-model="forms.pharmacy.chief_pharmacist_name" 
              type="text" 
              placeholder="Chief Pharmacist Name" 
              class="input">
          </div>
          <div class="field">
            <input 
              v-model="forms.pharmacy.chief_pharmacist_phone" 
              type="text" 
              placeholder="Chief Pharmacist Phone Number" 
              class="input">
          </div>

          <div class="field">
            <input 
              v-model="forms.pharmacy.chief_pharmacist_reg" 
              type="text" 
              placeholder="Chief Pharmacist Reg. No" 
              class="input">
          </div>

          <div class="field">
            <label 
              class="menu-label" 
              for="">Chief Pharmacist Reg. Date</label>
            <input 
              v-model="forms.pharmacy.chief_pharmacist_reg_date" 
              type="date" 
              placeholder="Chief Pharmacist Reg. Date" 
              class="input">
          </div>
        </div>
      </section>
      <!-- business information -->
      <section>
        <div class="menu-label">Business Information</div>
        <div 
          v-if="is('laboratory')" 
          class="field">
          <input 
            v-model="forms.laboratory.licence_no" 
            type="text" 
            class="input" 
            placeholder="License No">
        </div>                
        <section 
          v-if="is('pharmacy')" 
          class="field">
          <div class="field">
            <input 
              v-model="forms.pharmacy.business_name" 
              type="text" 
              class="input" 
              placeholder="Business Name">
          </div>
          <div class="field">
            <input 
              v-model="forms.pharmacy.business_type" 
              type="text" 
              class="input" 
              placeholder="Business Type">
          </div>
        </section>
        <div 
          v-if="is('hospital')" 
          class="field">
          <input 
            v-model="forms.generic.facility_type" 
            type="number" 
            class="input" 
            placeholder="Facility Type">
        </div>
        <div 
          v-if="!is('laboratory')" 
          class="field">
          <input 
            v-model="forms.generic.facility_owner" 
            type="number" 
            class="input" 
            placeholder="Facility Owner">
        </div>
        <div class="field">
          <label 
            class="menu-label" 
            for="">CAC Reg. No</label>
          <input 
            v-model="forms.generic.cac_reg" 
            type="text" 
            class="input" 
            placeholder="CAC Reg. No">
        </div>
                
        <div 
          v-if="is('hospital') || is('pharmacy')" 
          class="field">
          <label 
            class="menu-label" 
            for="">CAC Reg. Date</label>
          <input 
            v-model="forms.generic.cac_date" 
            type="date" 
            class="input" 
            placeholder="CAC Date">
        </div>

        <div class="field">
          <label 
            class="menu-label" 
            for="">FMOH Reg. No</label>
          <input 
            v-model="forms.generic.fmoh_reg" 
            type="text" 
            class="input" 
            placeholder="FMOH Reg. No">
        </div>

        <div 
          v-if="is('hospital') || is('pharmacy')" 
          class="field">
          <label 
            class="menu-label" 
            for="">FMOH Reg. Date</label>
          <input 
            v-model="forms.generic.fmoh_date" 
            type="date" 
            class="input" 
            placeholder="FMOH Date">
        </div>

        <div v-if="is('hospital')">
          <hr>
          <div class="menu-label">BANK INFORMATION</div>
          <div class="field">
            <input 
              v-model="forms.hospital.bank_name" 
              type="text" 
              class="input" 
              placeholder="Bank Name">
          </div>
          <div class="field">
            <input 
              v-model="forms.hospital.bank_branch" 
              type="text" 
              class="input" 
              placeholder="Bank Branch">
          </div>
          <div class="field">
            <input 
              v-model="forms.hospital.account_name" 
              type="text" 
              class="input" 
              placeholder="Account Name">
          </div>
          <div class="field">
            <input 
              v-model="forms.hospital.account_number" 
              type="number" 
              maxlength="10" 
              class="input" 
              placeholder="Account Number">
          </div>
        </div>
      </section>
    </div>
    <notifications 
      :position="['right', 'bottom']" 
      group="create"/>
  </section>
</template>

<style lang="sass">
    .buttons
        > .button
            margin-top: -16px
            border-radius: 0 0 20px 20px

            .icon 
                height: 1.2em !important
</style>

<script>
export default {
    name: 'CreateServiceProvider',
    directives: {
        'select-form': {
            bind(el, binding, vnode) {
                let {context} = vnode
                $(el).click(() => {
                    $(el).addClass('is-primary').siblings().removeClass('is-primary')
                    context.$set(context,'model', binding.value)
                })
            }
        }
    },
    data() {
        return {
            loading: false,
            model: 'hospital',
            modelMaps: {
                hospital: '/api/admin/hospitals',
                laboratory: '/api/admin/laboratories',
                pharmacy: '/api/admin/pharmacies',
            },
            forms: {
                pharmacy: {},
                laboratory: {
                    offers: '',
                },
                hospital: {},
                //  {
                //     "director_mdcn": "MD-30939-3093940092",
                //     "website": "http://fishes.com",
                //     "bank_name": "Fidelitiy Bank",
                //     "bank_branch": "Diobu",
                //     "account_name": "Bradley Yarrow",
                //     "account_number": "090909090",
                //     "services": "Surgery, Heart Diseases, X-ray"
                // },
                generic: {
                    'city': 0,
                    'state': 0,
                    'country': 0,
                },
                //  {
                //  "name": "New Era Hospital",
                //     "email": "kelley20@example.com",
                //     "phone": "252-582-5657 x62181",
                //     "address": "673 Niko Corner Apt. 054\nVivianneville, IA 48169",
                //     "city": "Luisfurt",
                //     "state": "Hodkiewiczview",
                //     "country": "Mongolia",
                //     "facility_type": "3",
                //     "facility_owner": "6",
                //     "cac_reg": "RC039950930",
                //     "fmoh_reg": "FMOH-3094-0848",
                //     "cac_date": "2018-03-07",
                //     "fmoh_date": "2008-12-25",
                // }
            },
        }
    },
    methods: {
        is(model) {
            return this.model === model
        },
        getData() {
            let { generic, [this.model]: model } = this.forms
            return () => {
                this.loading = true
                return Object.assign({}, model, generic)
            }
        },
        success() {
            this.loading = false
            this.forms.hospital = this.forms.generic = {}
            this.$notify({
                group: 'create',
                type: 'success',
                text: 'Account Created Successfully',
                duration: 1000
            })
        },
        error(err) {
            this.loading = false
            let { response: res } = err
            if (res.status === 422)
                for (let error of Object.values(res.data.errors)) {
                    this.$notify({
                        group: 'create',
                        type: 'error',
                        text: error[0],
                        duration: 3000
                    })
                }
        },
        register() {
            const { success, error, getData: data, modelMaps, model} = this
            this.$http.post(modelMaps[model], data()())
                .then(success.bind(this))
                .catch(error.bind(this))
        }
    }
}
</script>
