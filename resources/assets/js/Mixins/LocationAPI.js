export default {
	data() {return {
		selected: 0,
		entries: [],
	}},
	watch: {
		selected(a) {
			this.changed(a)
		},
	},
	methods: {
		changed() {
			this.$emit('changed', this.selected)
		},
		baseUrl() {
			return 'http://locationsng-api.herokuapp.com/api/v1/'
		},
		getLgas(state) {
			this.$http.get(`${this.baseUrl()}/states/${state}/lgas`)
				.then(res => this.entries = res.data)
				.catch(err => console.warn('Error Fetching L.G.As', err))
		},
		getStates() {
			this.$http.get(`${this.baseUrl()}/states`)
				.then(res => this.entries = res.data)
				.catch(err => console.warn('Error fetching States', err))
		}
	}
}