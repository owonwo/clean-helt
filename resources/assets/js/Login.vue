<template>
    <div id="osq-login">
        <form name="login" method="POST" :action="form_action" class="has-text-centered">
            <img class="logo" src="/images/assets/logo.png" alt="">
            <p v-if="['DOCTOR','PATIENT'].includes(provider)" class="mt-50 mb-15">Login as a</p>
            <p v-else class="mt-50 mb-15">Login</p>
            <slot></slot>
            <!-- error notification -->

            <div v-if="['DOCTOR','PATIENT'].includes(provider)" class="field is-flex" style="justify-content: center">
                <div class="select is-rounded" style="width: 180px">
                    <select v-model="type" class="has-text-centered">
                        <option selected :value="1">Client</option>
                        <option :value="2">Doctor</option>
                    </select>
                </div>
            </div>
            <transition name="fade">
                <div v-show="error" class="notification is-danger">
                    Invalid Email or Password.
                </div>
            </transition>
            <div class="field">
                <input name="email" placeholder="Email..." class="input" type="text" v-model="username">
            </div>
            <div class="field">
                <input name="password" placeholder="Password..." class="input" type="password" v-model="password">
            </div>
            <button @click.prevent="login" type="submit" class="button is-submit">LOGIN</button>
            <template v-if="modelIs('PATIENT', 'DOCTOR')">
                <div class="mt-15">Not Registered with CleanHelt?</div>
                <a class="has-text-primary" :href="register">Sign Up Here</a>
            </template>
        </form>
    </div>
</template>

<script>
export default {
    name: "Login",
    props: {
        model: { type: String, default: "", required: true},
    },
    data() {return {
        username: "",
        password: "",
        remember: false,
        type: 1,
        error: false,
        providerMap: {
            'PATIENT': {auth_key: 'patient',name: 'patients'},
            'DOCTOR': {auth_key: 'doctor', name: 'doctors'},
            'PHARMACY': {auth_key: 'pharmacy', name: 'pharmacies'},
            'HOSPITAL': {auth_key: 'hospital', name: 'hospitals'},
            'ADMIN': {auth_key: 'admins', name: 'admins'},
        },
        apiClient: {
            client_id: '2',
            client_secret: 'q0NNWjUhZTNqLlFq0noYyru70LkADVuK5kZj8M9b',
            grant_type: 'password'
        }
    }},
    computed: {
        register() { 
            return this.type === 1 ? '/register' : '/register?type=doctor' 
        },
        form_action() { return this.$props.model !== 'ADMIN' ? '/login/' + this.auth : '/admin/login' },
        provider() {
            let {model} = this.$props;
            return !['DOCTOR', 'PATIENT'].includes(model) ? model : (this.type === 1) ? 'PATIENT' : 'DOCTOR';
        },
        auth() {
            return this.providerMap[this.provider].auth_key;
        },
        modelstate() {
            return this.modelIs('PATIENT', 'DOCTOR');
        }
    },
    methods: {
        modelIs(...args) {
            return args.includes(this.$props.model);
        },
        login() {
            let {username, password, providerMap} = this;
            const provider = providerMap[this.provider].name;
            const data = Object.assign({provider}, {username, password, provider}, this.apiClient);

            this.$http.post('/oauth/token', data).then((res) => {

                localStorage.setItem('api-token', res.data.access_token);
                localStorage.setItem('refresh-token', res.data.refresh_token);
                document.cookie = "api-token=" + res.data.access_token;
                document.forms.login.submit();

            }).catch((err) => {
                if(err.response.status === 401) this.error = true;
                setTimeout(() => {
                    this.error = false;
                }, 3000);
            });
        },
    }
}
</script>
