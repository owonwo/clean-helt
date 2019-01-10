<template>
  <section>
    <section class="card">
      <section class="card-header">
        <div 
          class="card-header-title" 
          style="justify-content: space-between;">
          Doctor Directory
          <search-box 
            style="width: 300px"
            shape="is-rounded" 
            placeholder="Search" />
        </div>
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
              :to="{name: 'doctor-profile', params: {'_id': 1}}" 
              tag="span">
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
      size="sm" 
      @closed="modal = false && isLoading.reset ">
      <div class="content is-center">
        <h5 class="title is-6">
          <i class="ti ti-share icon"/> Assign Patient
        </h5>
        <div 
          v-if="sharedProfiles.length <= 0" 
          class="notification is-info">No Available Client.</div>
        <div 
          v-else 
          class="field">
          <select 
            v-model="selected.share_id" 
            class="input">
            <option 
              value="0" 
              disabled="" 
              selected="">Select Patient...</option>
            <option 
              v-for="(profile) in sharedProfiles" 
              :value="profile.id" 
              :key="profile.id">
              {{ profile.patient.chcode }} - {{ profile.patient.name }}
            </option>
          </select>
        </div>
        <div class="field">
          <button  
            v-if="!isLoading.loaded && selected.share_id !== 0"
            :class="{'is-loading': isLoading.message == 'loading'}" 
            class="button is-fullwidth is-primary is-block is-outlined"
            @click="shareToDoctor()">
            Assign
          </button>
        </div>
      </div>
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'

export default {
	name: 'DoctorDirectory',
	data() {return {
		modal: false,
		isLoading: { doctors: true, },
		selected: {doctor_id: 0, share_id: 0},
	}},
	computed: {
		...mapState('hospital', ['doctors']) ,
		...mapState('manage_patient', {
			sharedProfiles: 'patients'
		})
	},
	created() {
		this.$store.dispatch('hospital/FETCH_DOCTORS')
			.then(() => this.isLoading.doctors = false)
	},
	methods: {
		showAssignModal(doctor) {
			(this.modal = true)
			// this.isLoading.reset
			this.selected.doctor_id = doctor.chcode
		},
		shareToDoctor() {
			let {share_id, doctor_id} = this.selected

			this.$store.dispatch('hospital/SHARE_TO_DOCTOR', {share_id, doctor_id})
				.then(() => this.$refs.modal.hide())
				.then(() => this.$store.dispatch('hospital/FETCH_DOCTORS'))
        .then(() => this.success_message('Profile share successful'))
				.catch((err) => {
					console.log(err)
				})
		}
	}
}	
</script>
