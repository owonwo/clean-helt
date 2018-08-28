
export default {
    created() {
        this.$http.get(this.profile.route).then((res) => {
            this.user = _.extend(this.user, res.data[this.profile.key])
        });
    },
    data() {return {
        user: {
            first_name: "",
            last_name: "",
            get full_name() {
                return [this.first_name, this.last_name].join(' ')
            }
        },
    }}
}