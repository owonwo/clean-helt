<template>
    <section class="content">
        <div class="content-top-bar">Create a Service Provider</div>
        <div class="level " style="justify-content: flex-start;">
            <div class="buttons">
                <button @click="set('hospital', $event)" class="button is-normal is-primary">
                    <i class="osf osf-hospital"></i> Hospital
                </button>
                <button @click="set('pharmacy', $event)" class="button is-normal">
                    <i class="osf osf-pharmacy"></i> Pharmacy
                </button>
                <button @click="set('laboratory', $event)" class="button is-normal">
                    <i class="osf osf-lab"></i> Laboratory
                </button>
            </div>
        </div>
        <div id="create-user-form">
            <section>
                <div class="menu-label">{{ model | ucfirst }} Information</div>
                <div class="field">
                    <input type="text" class="input" placeholder="Name" v-model="forms.generic.name">
                </div>
                <div class="field">
                    <input type="text" class="input" placeholder="Email" v-model="forms.generic.email">
                </div>
                <div class="field">
                    <input type="text" class="input" placeholder="Telephone" v-model="forms.generic.phone">
                </div>
                <div class="field">
                    <div class="select is-block">
                        <select v-model="forms.generic.city" name="city" class="input">
                            <option disabled="" value="0" selected="">Select City...</option>
                            <option>Port Harcourt</option>
                            <option>Town</option>
                            <option>Borikir</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="select is-block">
                        <select class="input" v-model="forms.generic.state">
                            <option disabled="" value="0">Select State...</option>
                            <option>Rivers</option>
                            <option>Bayelsa</option>
                            <option>Delta</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="select is-block">
                        <select class="input" v-model="forms.generic.country">
                            <option value="0" selected="">Select Country...</option>
                            <option>Nigeria</option>
                            <option>Ghana</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <textarea class="textarea" placeholder="Address" v-model="forms.generic.address"></textarea>
                </div>
                <div v-if="model !== 'laboratory'" class="field">
                    <input type="text" class="input" placeholder="Services" v-model="forms.generic.services">
                    <div class="help is-bold"><b>Seperate by comma (,)</b></div>
                </div>
                <div v-else class="field">
                    <input type="text" class="input" placeholder="Offers" v-model="forms.laboratory.offers">
                    <div class="help is-bold"><b>Seperate by comma (,)</b></div>                	
                </div>
                <div class="field">
                    <input type="text" class="input" placeholder="https://hospital.care" v-model="forms.hospital.website">
                    <div class="help is-bold">Hospital Website if any.</div>
                </div>
                <button :class="{'is-loading': loading }" @click="register" class="button is-primary">
                    Register
                </button>
            </section>
            <!-- directors form -->
            <section>
                <div class="menu-label">Directors Information</div>
                <div v-if="is('hospital')" class="field">
                    <input type="text" v-model="forms.hospital.director_mdcn" class="input" placeholder="Director MDCN">
                </div>
                <div v-if="is('laboratory')" class="field">
                    <input type="number" v-model="forms.laboratory.lab_owner" class="input" placeholder="Laboratory  Owner">
                </div>                
                <!-- pharmacy chief information -->
                <div v-show="is('pharmacy')">
                    <div class="field">
                        <input v-model="forms.pharmacy.chief_pharmacist_name" type="text" placeholder="Chief Pharmacist Name" class="input">
                    </div>
                    <div class="field">
                        <input v-model="forms.pharmacy.chief_pharmacist_phone" type="text" placeholder="Chief Pharmacist Phone Number" class="input">
                    </div>

                    <div class="field">
                        <input v-model="forms.pharmacy.chief_pharmacist_reg" type="text" placeholder="Chief Pharmacist Reg. No" class="input">
                    </div>

                    <div class="field">
                        <label class="menu-label" for="">Chief Pharmacist Reg. Date</label>
                        <input v-model="forms.pharmacy.chief_pharmacist_reg_date" type="date" placeholder="Chief Pharmacist Reg. Date" class="input">
                    </div>
                </div>
            </section>
            <!-- business information -->
            <section>
                <div class="menu-label">Business Information</div>
                <div v-if="is('laboratory')" class="field">
                    <input type="number" v-model="forms.laboratory.licence_no" class="input" placeholder="License No">
                </div>                
                <section v-if="is('pharmacy')" class="field">
                    <div class="field">
                        <input type="number" v-model="forms.pharmacy.business_name" class="input" placeholder="Business Name">
                    </div>
                    <div class="field">
                        <input type="number" v-model="forms.pharmacy.business_type" class="input" placeholder="Business Type">
                    </div>
                </section>
                <div v-if="is('hospital')" class="field">
                    <input type="number" v-model="forms.generic.facility_type" class="input" placeholder="Facility Type">
                </div>
                <div v-if="!is('laboratory')" class="field">
                    <input type="number" v-model="forms.generic.facility_owner" class="input" placeholder="Facility Owner">
                </div>
                <div class="field">
                    <input type="text" v-model="forms.generic.cac_reg" class="input" placeholder="CAC Reg. No">
                </div>
                <div class="field">
                    <input type="text" v-model="forms.generic.fmoh_reg" class="input" placeholder="FMOH Reg. No">
                </div>

                <div class="field">
                    <label class="menu-label" for="">CAC Reg. Date</label>
                    <input type="date" v-model="forms.generic.cac_date" class="input" placeholder="CAC Date">
                </div>

                <div class="field">
                    <label class="menu-label" for="">FMOH Reg. Date</label>
                    <input type="date" v-model="forms.generic.fmoh_date" class="input" placeholder="FMOH Date">
                </div>
                <div v-if="is('hospital')">
                    <hr>
                    <div class="menu-label">BANK INFORMATION</div>
                    <div class="field">
                        <input type="text" class="input" placeholder="Bank Name" v-model="forms.hospital.bank_name">
                    </div>
                    <div class="field">
                        <input type="text" class="input" placeholder="Bank Branch" v-model="forms.hospital.bank_branch">
                    </div>
                    <div class="field">
                        <input type="text" class="input" placeholder="Account Name" v-model="forms.hospital.account_name">
                    </div>
                    <div class="field">
                        <input type="number" maxlength="10" class="input" placeholder="Account Number" v-model="forms.hospital.account_number">
                    </div>
                </div>
            </section>
        </div>
        <notifications group="create" :position="['right', 'bottom']"></notifications>
    </section>
</template>

<script>
export default {
    name: 'CreateServiceProvider',
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
                laboratory: {},
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
                    "city": 0,
                    "state": 0,
                    "country": 0,
                },
                //  {
                // 	"name": "New Era Hospital",
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
    computed: {},
    methods: {
        is(model) {
            return this.model === model;
        },
        set(model, node) {
        	$(event.target).addClass('is-primary').siblings().removeClass('is-primary')
        	this.model = model
        },
        getData() {
            let { generic, [this.model]: model } = this.forms;
            return () => {
                this.loading = true;
                return Object.assign({}, model, generic);
            }
        },
        success(res) {
            this.loading = false
            this.forms.hospital = this.forms.generic = {};
            this.$notify({
                group: 'create',
                type: 'success',
                text: 'Account Created Successfully',
                duration: 1000
            });
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
                    });
                };
        },
        register() {
            const { success, error, getData: data, modelMaps, model} = this;
            this.$http.post(modelMaps[model], data()())
                .then(success.bind(this))
                .catch(error.bind(this));
        }
    }
}
</script>
