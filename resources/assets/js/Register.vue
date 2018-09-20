<template>
    <div id="osq-login">
        <section class="has-text-centered">
            <img class="logo" src="/images/assets/logo-full@4.png" alt="">
            <p v-if="page !== 3" class="mt-50 mb-15">Sign up here. Only takes a few minutes</p>
            <pager :current="page">
                <!-- Personal Details -->
                <section slot="p1">
                    <div class="field">
                        <input placeholder="First Name" class="input" type="text" v-model="field.first_name">
                    </div>
                    <div class="field">
                        <input placeholder="Middle Name" class="input" type="text" v-model="field.middle_name">
                    </div>
                    <div class="field">
                        <input placeholder="Last Name" class="input" type="text" v-model="field.last_name">
                    </div>
                    <div class="field">
                        <label for="" class="field-label">Date of Birth:</label>
                        <input type="date" v-model="field.dob" class="input" placeholder="Date of Birth">
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.gender">
                                <option disabled selected="">Select Gender...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <input v-model="field.phone" minlength="11" min="0" placeholder="Phone Number" class="input" type="number" name="phone">
                        <span v-if="!!errors.phone" class="help has-text-danger">{{ errors.phone[0] }}</span>
                    </div>
                    <hr>
                    <div class="field">
                        <input type="email" v-model="field.email" placeholder="Enter Email" class="input" />
                        <span v-if="!!errors.email" class="help has-text-danger">This email `{{ field.email }}` has already been taken.</span>
                    </div>
                    <div class="field">
                        <input placeholder="Password" v-model="field.password" class="input" type="password">
                    </div>
                    <button type="button" @click.prevent="page = 1" class="button is-submit">Next</button>
                </section>
                <!-- Contact Information -->
                <section slot="p2">
                    <div class="field">
                        <textarea v-model="field.address" class="textarea" placeholder="Address" rows=2></textarea>
                    </div>
                    <div class="field">
                        <select v-model="field.city" name="city" class="input">
                            <option disabled="" selected="">Pick City...</option>
                            <option>Port Harcourt</option>
                            <option>Town</option>
                            <option>Borikir</option>
                        </select>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.state">
                                <option disabled=""> State...</option>
                                <option>Rivers</option>
                                <option>Bayelsa</option>
                                <option>Delta</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <div class="select">
                            <select v-model="field.country">
                                <option disabled="" selected=""> Country...</option>
                                <option>Nigeria</option>
                                <option>Ghana</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.religion">
                                <option disabled="">Select Religion...</option>
                                <option>Christainity</option>
                                <option>Muslim</option>
                                <option>Islam</option>
                                <option>Others...</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.marital_status">
                                <option disabled="">Select Marital Status...</option>
                                <option>Married</option>
                                <option>Single</option>
                            </select>
                        </div>
                    </div>
                    <div class="is-flex" style="justify-content: space-between;">
                        <button type="button" @click.prevent="page = 0" class="button is-normal">Back</button>
                        <button type="button" @click.prevent="page = 2" class="button is-submit">Next</button>
                    </div>
                </section>
                <!-- Next of Kin -->
                <section slot="p3">
                    <div class="field">
                        <input v-model="field.nok_name" placeholder="Next of Kin" class="input" type="text">
                    </div>
                    <div class="field">
                        <input v-model="field.nok_email" placeholder="Email" class="input" type="email">
                    </div>                    
                    <div class="field">
                        <input v-model="field.nok_phone" min="0" minlength="11" placeholder="Phone Number" class="input" type="number">
                    </div>                    
                    <div class="field">
                        <textarea v-model="field.nok_address" class="textarea" placeholder="Address" rows=2></textarea>
                    </div>

                    <div class="field">
                        <div class="select">
                            <select v-model="field.nok_city" >
                                <option disabled="" selected="">Pick City...</option>
                                <option>Port Harcourt</option>
                                <option>Town</option>
                                <option>Borikir</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.nok_state">
                                <option disabled="" selected> State...</option>
                                <option>Rivers</option>
                                <option>Bayelsa</option>
                                <option>Delta</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select class="input" v-model="field.nok_country"  name="country">
                                <option disabled="" selected=""> Country...</option>
                                <option>Nigeria</option>
                                <option>Ghana</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="select">
                            <select v-model="field.nok_relationship">
                                <option disabled selected="">Relationship</option>
                                <option v-for="type in relationships">{{ type }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="field is-flex" style="justify-content: space-between;">
                        <button type="button" @click.prevent="page = 1" class="button is-normal">Back</button>
                        <button @click="submit()" type="submit" class="button is-submit">FINISH</button>
                    </div>
                </section>
                <section slot="p4">
                    <div>
                        <h3 class="title mt-30 is-4">Registration Succesful</h3>
                        <p class="mb-50">You have successfully registered you account. An account verification email has been sent to your 
                        email.</p>
                        <button @click="visit_login" class="button is-primary">Login</button>
                    </div>
                </section>
            </pager>
        </section>
    </div>
</template>
<script>
export default {
    name: "Register",
    props: {
        model: { type: String, default: "", required: true },
    },
    mounted() {
        console.clear()
        setTimeout(() => {
            console.log('calling the notification');
        }, 100);
    },
    data() {
        return {
            page: 0,
            field: {},
            login_details: {
                username: "",
                password: "",
            },
            errors: {},
            relationships: ['Brother', 'Mother', 'Father', 'Sister', 'Uncle', 'Aunty', 'Son', 'Daughter'],
            providerMap: {
                'PATIENT': { auth_key: 'patient', name: 'patients' },
                'DOCTOR': { auth_key: 'doctor', name: 'doctors' },
                'PHARMACY': { auth_key: 'pharmacy', name: 'pharmacies' },
                'HOSPITAL': { auth_key: 'hospital', name: 'hospitals' },
            },
            apiClient: {
                client_id: '2',
                client_secret: 'q0NNWjUhZTNqLlFq0noYyru70LkADVuK5kZj8M9b',
                grant_type: 'password'
            }
        }
    },
    computed: {
        provider() {
            let { model } = this.$props;
            return !['DOCTOR', 'PATIENT'].includes(model) ? model : (this.type === 1) ? 'PATIENT' : 'DOCTOR';
        },
        auth() {
            return this.providerMap[this.provider].auth_key;
        }
    },
    methods: {
        visit_login() {
            window.location = '/login';
        },
        submit() {
            this.errors = {};
            this.$http.post('/api/patient/register', this.field).then((res) => {
                this.page = 3;
            }).catch((err) => {
                //user already exist
                if(err.response.status === 422) {
                    this.$notify({
                        group: 'register', 
                        type: 'error',
                        duration: 2000,
                        text: 'Some fields need attention.', 
                    });
                    this.errors = err.response.data.errors;
                }
                if(err.response.status === 403) 
                    this.$notify({
                        group: 'register', 
                        type: 'info',
                        duration: 5000,
                        text: `Am sorry, We can't create an account at the moment, please try again later.`, 
                    });
            });
        }
    }
}
</script>
