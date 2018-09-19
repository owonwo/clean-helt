<template>
    <div id="osq-login">
        <form name="login" method="POST" :action="'/login/' + auth" class="has-text-centered">
            <img class="logo" src="/images/assets/logo-full@4.png" alt="">
            <p class="mt-50 mb-15">Login as </p>
            <slot></slot>
            <!-- error notification -->

            <div v-if="['DOCTOR','PATIENT'].includes(provider)" class="field is-flex" style="justify-content: center">
                <div class="control has-icons-left">
                    <span class="icon is-left"><i class="ti ti-user"></i></span>
                    <div class="select is-rounded">
                        <select v-model="type">
                            <option selected :value="1">Client</option>
                            <option :value="2">Doctor</option>
                        </select>
                    </div>
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
            <div class="mt-15">Not Registered with CleanHelt?</div>
            <small><a href="/register">Sign Up Here</a></small>
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
        username: "rocio.daniel@example.com",
        password: "secret",
        remember: false,
        type: 1,
        error: false,
        providerMap: {
            'PATIENT': {auth_key: 'patient',name: 'patients'},
            'DOCTOR': {auth_key: 'doctor', name: 'doctors'},
            'PHARMACY': {auth_key: 'pharmacy', name: 'pharmacies'},
            'HOSPITAL': {auth_key: 'hospital', name: 'hospitals'},
        },
        apiClient: {
            client_id: '2',
            client_secret: 'q0NNWjUhZTNqLlFq0noYyru70LkADVuK5kZj8M9b',
            grant_type: 'password'
        }
    }},
    computed: {
        provider() {
            let {model} = this.$props;
            return !['DOCTOR', 'PATIENT'].includes(model) ? model : (this.type === 1) ? 'PATIENT' : 'DOCTOR';
        },
        auth() {
            return this.providerMap[this.provider].auth_key;
        }
    },
    methods: {
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
