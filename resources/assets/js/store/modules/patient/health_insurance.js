import axios from 'axios'
import { VuexError, extractRecords } from '@/store/helpers/utilities'

const state = {
	insurances: [],
}

const mutations = {
	set_insurances: (store, payload) => store.insurances = payload,
}

const actions = {
	FETCH(context) {
		return axios.get('/api/patient/record/health-insurance').then(({data}) => {
			context.commit('set_insurances', extractRecords(data.data))
		}).catch(VuexError('Error Fetching Insurances.'))
	},
	async CREATE (context, payload) {
		try {
			const data = await axios.post('/api/patient/record/health-insurance', payload);
			const { insurances } = context.state
			insurances.push(payload)
			context.commit('set_insurances', insurances)
			return data
		} catch (x) {
			VuexError('Error Fetching Insurances.')()
			throw Error(x)
		}
	},
	DELETE(context, {id}) {
		return axios.delete(`/api/patient/record/${id}/health-insurance`)
			.then(() => {
				const changes = context.state.insurances.filter(e => id !== e.id)
				context.commit('set_insurances', changes)
			})
			.catch(VuexError(`Error deleting insurance with id: ${id}`))
	}
}

export default {
	namespaced: true,
	state,
	actions,
	mutations
}