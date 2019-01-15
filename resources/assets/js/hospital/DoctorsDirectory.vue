<template>
  <section>
    <section class="card">
      <section class="card-header level">
        <div class="card-header-title">
          Doctors Directory
        </div>
        <search-box 
          style="width: 300px"
          placeholder="Search" />
      </section>
      <div class="card-content p-0">
        <div 
          v-preload 
          v-if="isLoading.doctors"
          class="block is-rounded mx-15 my-5 mb-0"
          style="height:10px;border-radius: 0"/>
        <div 
          v-if="!doctors.length"
          class="card-content">
          <div>Hospital has no Doctor currently. 
            <router-link :to="{name: 'Settings'}"  tag="a">Add a doctor</router-link>
          </div>          
        </div>
        <table 
          v-else 
          class="table is-hoverable is-fullwidth">
          <tr>
            <th class="has-text-centered">S/N</th>
            <th>Full Name</th>
            <th>Specialization</th>
            <th>CHCODE</th>
            <th>Options</th>
          </tr>
          <tr 
            v-for="(doctor, key) in doctors" 
            :key="key">
            <td class="has-text-centered">{{ key + 1 }}</td>
            <td><router-link 
              :to="{name: 'doctor-profile', params: {'_id': doctor.chcode }}">
              Dr. {{ doctor.first_name }} {{ doctor.last_name }}
            </router-link></td>
            <td>{{ doctor.specialization | ucfirst }}</td>
            <td>{{ doctor.chcode }}</td>
            <td>
              <button 
                class="button is-hovered-success is-outlined is-rounded has-no-motion is-small" 
                @click="showAssignModal(doctor)">Assign</button>
            </td>
          </tr>
        </table>
      </div>
    </section>
    <modal 
      ref="modal"
      :show="modal"
      @closed="modal = false">
      <AssignPatient 
        :doctor="selected.doctor_id"
        @success="$refs.modal.hide()"/>
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import AssignPatient from './AssignPatient'

export default {
	name: 'DoctorDirectory',
  components: { AssignPatient },
	data() {return {
    modal: false,
		isLoading: { doctors: true, },
    selected: {doctor_id: 0}
	}},
	computed: {
		...mapState('hospital', ['doctors']),
	},
	created() {
		this.$store.dispatch('hospital/FETCH_DOCTORS')
			.then(() => this.isLoading.doctors = false)
	},
	methods: {
    showAssignModal(doctor) {
      this.modal = true
      this.selected.doctor_id = doctor.chcode
    },
	}
}	
</script>
