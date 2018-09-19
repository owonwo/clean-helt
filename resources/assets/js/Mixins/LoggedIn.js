import {mapGetters, mapMutations} from 'vuex';
const ServiceProviders = ['hospital', 'doctor', 'pharmacy', 'laboratory']

export default {
    props: ['id'],
    data() {return {
        notifications: []
    }},
    computed: {
        ...mapGetters({user: 'getUser', pendingUsers:'getPendingUsers'}),
        /**
         * @return String
         */
        componentName() { return this.getComponentName().toLowerCase() }
    },
    created() {
        //create the token for the application
        const token = localStorage.getItem('api-token');//$('meta[name=api-token]').attr('content');

        //checks if the user is valid
        if(!this.testChCode(this.$props.id) || typeof this.$props.id === 'undefined' || this.$props.id === '') 
            console.warn('Logged In User ChCode is invalid!, So features are bound to fail');
        if(!_.isUndefined(token) && 'string' === typeof token) {
            window.axios.defaults.headers.common = {
                'Authorization': `Bearer ${token}`,
            }
        }else{
            console.warn('The Logged In User has got no token!');
        }
    },
    mounted() {
        //for profiles
        const {profile, patients} = this.settings;
        if("undefined" !== typeof profile.route) 
        this.$http.get(profile.route).then((res) => {
            const USER_DATA = _.extend(this.user, res.data[profile.key])
            this.set_user(USER_DATA);
        });
        //for services providers
        this.$store.commit('set_account_type', this.componentName);

        !ServiceProviders.includes(this.componentName) || this.fetchPatients();
    },
    methods: {
        ...mapMutations([
            "set_user", 
            "set_pending_patients", 
            "remove_from_pending", 
            "set_shared_profiles"
        ]),
        getComponentName() {
            return this.$vnode.componentOptions.tag;
        },
        async acceptShare(id) {
            const url = `/api/${this.componentName}/patients/pending/${id}/accept`;
            return await this.$http.patch(url).then(() => {
                this.remove_from_pending(id);
                this.fetchPatients();
            }).catch(() => {
                console.log('Accept Failed!');
            })
        },
        // fetches both pending and active patients
        fetchPatients() {
            let {patients} = this.settings;
            
            this.$http.get(`/api/${this.componentName}/patients/pending`).then((res) => {
                const PATIENTS = res.data.patients;
                this.set_pending_patients(PATIENTS);
            });

            this.$http.get(patients.route).then((res) => {
                const PATIENTS = res.data[patients.key]
                this.set_shared_profiles(PATIENTS);
            });
        },
        logout() {
            let input = document.createElement('input');
            input.value = $('meta[name=csrf-token]').attr('content');
            input.name = "_token";
            let form = $('<form></form>');
            form.attr('action','/logout').attr('method', 'POST').append(input).submit();
            $('body').append(form);
            form.submit(); 
        }
    },
}
