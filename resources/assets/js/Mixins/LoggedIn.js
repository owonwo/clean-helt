import {mapMutations} from 'vuex';

export default {
    created() {
        this.$http.get(this.settings.profile.route).then((res) => {
            const USER_DATA = _.extend(this.user, res.data[this.settings.profile.key])
            this.set_user(USER_DATA);
        });
        this.$http.get(this.settings.patients.route).then((res) => {
            const PATIENTS =  res.data[this.settings.patients.key]
            this.set_shared_profiles(PATIENTS);
        });
    },
    methods: {
        ...mapMutations(["set_user", "set_shared_profiles"]),
    }
}
