import {mapMutations} from 'vuex';
const ServiceProviders = ['hospital', 'doctor', 'pharmacy', 'laboratory']
export default {
    props: ['id'],
    data() {return {
    }},
    mounted() {
        //for profiles
        this.$http.get(this.settings.profile.route).then((res) => {
            const USER_DATA = _.extend(this.user, res.data[this.settings.profile.key])
            this.set_user(USER_DATA);
        });
        //for services providerss
        if(ServiceProviders.includes(this.getComponentName())) {
            this.$http.get(this.settings.patients.route).then((res) => {
                const PATIENTS =  res.data[this.settings.patients.key]
                this.set_shared_profiles(PATIENTS);
            });
        }
    },
    methods: {
        ...mapMutations(["set_user", "set_shared_profiles"]),
        getComponentName() {
            return this.$vnode.componentOptions.tag;
        }
    },
}
