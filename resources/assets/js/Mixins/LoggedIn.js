import {mapGetters, mapMutations} from 'vuex';
const ServiceProviders = ['hospital', 'doctor', 'pharmacy', 'laboratory']

export default {
    props: ['id'],
    data() {return {
        notifications: []
    }},
    computed: {
        ...mapGetters({user: 'getUser', pendingUsers:'getPendingUsers'})
    },
    created() {
        const token = $('meta[name=api-token]').attr('content');
        if(!_.isUndefined(token) && 'string' === typeof token) {
            window.axios.defaults.headers.common = {
                'Authorization': `Bearer ${token}`,
            }
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
        const componentName = this.getComponentName().toLowerCase();
        this.$store.commit('set_account_type', componentName);

        if(ServiceProviders.includes(componentName)) {
            this.$http.get(patients.route).then((res) => {
                const PATIENTS =  res.data[patients.key]
                this.set_shared_profiles(PATIENTS);
            });
            this.$http.get(`/api/${componentName}/patients/pending`).then((res) => {
                const PATIENTS =  res.data.patients;
                this.set_pending_patients(PATIENTS);
            });
        }
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
            const url = `/api/${this.getComponentName()}/patients/pending/${id}/accept`;
            return await this.$http.patch(url).then(() => {
                this.remove_from_pending(id);
            }).catch(() => {
                console.log('Accept Failed!');
            })
        }
    },
}
