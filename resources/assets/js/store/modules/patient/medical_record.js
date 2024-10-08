import axios from 'axios'
import { VuexError, extractRecords, extractErrors, urlGenerator, REMOVE_CRUD_METHODS, guessDataKey } from '@/store/helpers/utilities'

const allergies = urlGenerator('allergies')
const immunization = urlGenerator('immunization')
const hospitalize = urlGenerator('hospitalization')
const medical_history = urlGenerator('medical_history')

const state = {
  /** @type <Array[{disease:"string", carriers: <Array["string"]> }]> */
  histories: [],
  allergies: [],
  hospitalizations: [],
  immunizations: [],
  options: {
    immunizations: [
      'Diptheria', 'H1N1 Flu', 'Hepatitis B',
      'Measles', 'Mumps', 'Whooping Cough', 'Polio',
      'Rubella', 'Tetanus', 'Tuberculosis', 'Typhoid'
    ],
    medical_history: [
      'Arthritis', 'Asthma', 'Bronchitis',
      'Cancer', 'Diabetes', 'Heart Condition',
      'Hepatitis', 'High Cholesterol', 'Kidney Disease',
      'Smoking', 'Stroke', 'High Blood Pressure',
      'Acquired Immunodeficiency Syndrome (AIDS or HIV Positive',
      'Kidney Disease', 'Low Blood Pressure', 'Pain or Pressure in chest',
      'Palpitations', 'Shortness of breath', 'Thyroid Problems',
      'Urinary Tract Infection'
    ],
    allergies: ['']
  }
}

const getters = {
  getMedicalHistories: (store) => store.histories
}

const mutations = {
  set_allergies(store, payload) {
    store.allergies = payload
  },
  set_hospitalizations(store, payload) {
    store.hospitalizations = payload
  },
  set_immunization(store, payload) {
    store.immunizations = payload
  },
  set_histories(store, payload) {
    store.histories = payload
  },
}

const actions = {
  FETCH_MEDICAL_HISTORY(context) {
    return axios.get(medical_history(context).base()).then(guessDataKey)
      .then(({ data }) => {
        context.commit('set_histories', extractRecords(data))
      }).catch(VuexError('Fetching Medical Histories Failed'))
  },
  async CREATE_MEDICAL_HISTORY(context, payload) {
    try {
      await axios.post(medical_history(context).base(), payload)
      context.dispatch('FETCH_MEDICAL_HISTORY')
      return
    } catch (x) {
      VuexError('Error Creating Medical History')(x)
      throw extractErrors(x)
    }
  },
  async UPDATE_MEDICAL_HISTORY(context, payload) {
    try {
      await axios.patch(medical_history(context).update(payload.id), REMOVE_CRUD_METHODS(payload))
      context.dispatch('FETCH_MEDICAL_HISTORY')
      return
    } catch (x) {
      VuexError('Error Updating Medical History')(x)
      throw extractErrors(x)
    }
  },
  async DELETE_MEDICAL_HISTORY(context, payload) {
    try {
      await axios.delete(medical_history(context).delete(payload))
      context.dispatch('FETCH_MEDICAL_HISTORY')
      return
    } catch (x) {
      VuexError('Error Deleting Medical History')(x)
      throw extractErrors(x)
    }
  },
  FETCH_ALLERGIES(context) {
    axios.get(allergies(context).base()).then(guessDataKey)
      .then(({ data }) => {
        context.commit('set_allergies', extractRecords(data))
      }).catch(VuexError('Error Fetching Allergies'))
  },
  async CREATE_ALLERGY(context, payload) {
    try {
      await axios.post(allergies(context).base(), payload)
      context.dispatch('FETCH_ALLERGIES')
      return
    } catch (x) {
      VuexError('Error Updating Allergy')(x)
      throw extractErrors(x)
    }
  },
  async UPDATE_ALLERGY(context, payload) {
    try {
      await axios.patch(allergies(context).update(payload.id), REMOVE_CRUD_METHODS(payload))
      context.dispatch('FETCH_ALLERGIES')
      return
    } catch (x) {
      VuexError('Error Updating Allergy')()
      throw x
    }
  },
  async DELETE_ALLERGY(context, id) {
    try {
      await axios.delete(allergies(context).delete(id))
      context.dispatch('FETCH_ALLERGIES')
      return
    } catch (x) {
      VuexError('Error Deleting Allergy')()
      throw x
    }
  },
  // HOSPITALIZATIONS
  FETCH_HOSPITALIZATIONS(context) {
    axios.get(hospitalize(context).base()).then(guessDataKey)
      .then(({ data }) => {
        context.commit('set_hospitalizations', extractRecords(data))
      }).catch(VuexError('Error Fetching Hospitalizations'))
  },
  CREATE_HOSPITALIZATION(context, payload) {
    axios.post(hospitalize(context).base(), payload)
      .then(() => context.dispatch('FETCH_HOSPITALIZATIONS'))
      .catch(VuexError('Error Creating Hospitalization'))
  },
  async UPDATE_HOSPITALIZATION(context, payload) {
    try {
      await axios.patch(hospitalize(context).update(payload.id), REMOVE_CRUD_METHODS(payload))
      context.dispatch('FETCH_HOSPITALIZATIONS')
      return
    } catch (x) {
      VuexError('Error Updating Hospitalization')(x)
      throw extractErrors(x)
    }
  },
  async DELETE_HOSPITALIZATION(context, payload) {
    try {
      await axios.delete(hospitalize(context).delete(payload.id), REMOVE_CRUD_METHODS(payload))
      context.dispatch('FETCH_HOSPITALIZATIONS')
      return
    } catch (x) {
      VuexError('Error Deleting Hospitalization')(x)
      throw extractErrors(x)
    }
  },
  // IMMUNIZATIONS
  FETCH_IMMUNIZATIONS(context) {
    axios.get(immunization(context).base()).then(guessDataKey)
      .then(({ data }) => {
        context.commit('set_immunization', extractRecords(data))
      }).catch(VuexError('Error Fetching immunizations'))
  },
  async CREATE_IMMUNIZATION(context, payload) {
    try {
      await axios.post(immunization(context).base(), payload)
      context.dispatch('FETCH_IMMUNIZATIONS')
      return
    } catch (x) {
      VuexError('Error Updating Immunization')()
      throw x
    }
  },
  async UPDATE_IMMUNIZATION(context, payload) {
    try {
      await axios.patch(immunization(context).update(payload.id), REMOVE_CRUD_METHODS(payload))
      context.dispatch('FETCH_IMMUNIZATIONS')
      return
    } catch (x) {
      VuexError('Error Updating Immunization')()
      throw x
    }
  },
  async DELETE_IMMUNIZATION(context, id) {
    try {
      await axios.delete(immunization(context).delete(id))
      context.dispatch('FETCH_IMMUNIZATIONS')
      return
    } catch (x) {
      VuexError('Error Deleting Immunization')()
      throw x
    }
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}