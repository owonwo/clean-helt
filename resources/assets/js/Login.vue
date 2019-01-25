<template>
  <div id="osq-login">
    <header class="navbar level level-right">
      <div class="navbar-tabs">
        <div 
          class="navbar-item has-text-right" 
          style="flex-direction: column; align-items: flex-end">
          <div class="menu-label mb-0">Login As</div>
          <a 
            v-if="model !== 'HOSPITAL'" 
            href="/login?type=HOSPITAL">HOSPITAL</a>
          <a 
            v-if="model !== 'PATIENT'" 
            href="/login">CLIENT/DOCTOR</a>
        </div> 
      </div>
    </header>
        
    <form 
      :action="form_action" 
      name="login" 
      method="POST" 
      class="has-text-centered">
      <label 
        v-if="model === 'HOSPITAL'" 
        class="menu-label">HOSPITAL</label>
      <img 
        class="logo" 
        src="/images/assets/logo.png" 
        alt="">
      <slot/>
      <!-- error notification -->

      <div 
        v-if="['DOCTOR','PATIENT'].includes(provider)" 
        class="field is-flex" 
        style="justify-content: center">
        <div 
          class="select is-rounded" 
          style="width: 180px">
          <select 
            id="account" 
            v-model="type" 
            class="has-text-centered">
            <option 
              :value="1" 
              selected>Client</option>
            <option :value="2">Doctor</option>
          </select>
        </div>
      </div>
      <transition name="fade">
        <div 
          v-show="error" 
          class="notification is-danger">
          Invalid Email or Password.
        </div>
      </transition>
      <div class="field">
        <label for="email" class="is-hidden">Email</label>
        <input 
          id="email" 
          v-model="username" 
          name="email" 
          placeholder="Email..." 
          class="input" 
          type="text">
      </div>
      <div class="field">
        <label for="pass" class="is-hidden">Password</label>
        <input 
          id="pass" 
          v-model="password" 
          name="password" 
          placeholder="Password..." 
          class="input" 
          type="password">
          <div class="help has-text-right">
            <a :href="forgot_link">Forgot Password?</a>
          </div>
      </div>
      <button 
        :class="{'is-loading': isLoading}" 
        type="submit" 
        class="button is-submit" 
        @click.prevent="login">LOGIN</button>
      <template v-if="modelIs('PATIENT', 'DOCTOR')">
        <div class="mt-15">Not Registered with CleanHelt?</div>
        <a 
          :href="register" 
          class="has-text-primary">Sign Up Here</a>
      </template>
    </form>
  </div>
</template>

<script>
export default {
    name: 'Login',
    props: {
        model: { type: String, default: '', required: true},
    },
    data() {return {
        username: '',
        password: '',
        remember: false,
        type: 1,
        isLoading: false,
        error: false,
        providerMap: {
            'PATIENT': {auth_key: 'patient',name: 'patients'},
            'DOCTOR': {auth_key: 'doctor', name: 'doctors'},
            'PHARMACY': {auth_key: 'pharmacy', name: 'pharmacies'},
            'HOSPITAL': {auth_key: 'hospital', name: 'hospitals'},
            'ADMIN': {auth_key: 'admins', name: 'admins'},
            'LABORATORY': {auth_key: 'laboratory', name: 'laboratories'},
        },
        apiClient: {
            client_id: '2',
            client_secret: '5BPTzV4pvEboaEigTGC0vGhPVjxdpAs6Nv7OmwFj',
            grant_type: 'password'
        }
    }},
    computed: {
        register() { 
            return this.type === 1 ? '/register' : '/register?type=doctor' 
        },
        form_action() { return this.$props.model !== 'ADMIN' ? '/login/' + this.auth : '/admin/login' },
        provider() {
            let {model} = this.$props
            return !['DOCTOR', 'PATIENT'].includes(model) ? model : (this.type === 1) ? 'PATIENT' : 'DOCTOR'
        },
        forgot_link() {
          const { providerIs } = this
          return providerIs('PATIENT') ? '/patients/password/reset' : 
            providerIs('DOCTOR') ? '/password/reset/doctors' : ''
        },
        auth() {
            return this.providerMap[this.provider].auth_key
        },
        modelstate() {
            return this.modelIs('PATIENT', 'DOCTOR')
        }
    },
    mounted() {
      document.title = 'Login - CleanHelt'
    },
    methods: {
        modelIs(...args) {
            return args.includes(this.$props.model)
        },
        providerIs(provider) {
          return this.provider === provider
        },
        login() {
            this.isLoading = true
            let {username, password, providerMap} = this
            const provider = providerMap[this.provider].name
            const data = Object.assign({provider}, {username, password, provider}, this.apiClient)

            this.$http.post('/oauth/token', data).then((res) => {

                localStorage.setItem('api-token', res.data.access_token)
                localStorage.setItem('refresh-token', res.data.refresh_token)
                document.cookie = 'api-token=' + res.data.access_token
                document.forms.login.submit()

            }).catch((err) => {
                this.isLoading = false
                if(err.response.status === 401) this.error = true
                setTimeout(() => {
                    this.error = false
                }, 3000)
            })
        },
    }
}
</script>
