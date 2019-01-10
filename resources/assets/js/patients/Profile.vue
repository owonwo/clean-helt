<template>
  <section>
    <section class="content-top-bar">
      <h3>Profile</h3>
    </section>
    <profile-grid 
      :name="user.name" 
      :avatar="user.avatar" 
      :avatar-url="(isPatient ? edit.avatarUrl : '')">
      <template 
        slot="navigation" 
        class="osq-sidenav p-10">
        <li><a href="#basic">Basic Information</a></li>
        <li><a href="#annual">Annual Medical Check</a></li>
        <li><a href="#medical">Medical History</a></li>
        <li><a href="#immunization">Immunization</a></li>
        <li><a href="#allergies">Allergies</a></li>
        <li><a href="#family">Family Medical History</a></li>
        <li><a href="#hospitalize">Hospitalization</a></li>
        <li><a href="#log">Health Log</a></li>
        <li><a href="#contacts">Emergency Contacts</a></li>
        <li><a href="#hospital-contacts">Hospital Contacts</a></li>
        <li><a href="#insurance">Health Insurance Providers</a></li>
      </template>
      <template slot-scope="pager">
        <pager :current="pager.page">
          <div 
            slot="p1" 
            class="">
            <div class="menu-label">User Information</div>
            <accordion :show="true">
              <template slot="heading">Basic</template>
              <section slot="content">
                <save-edit-button 
                  v-if="isPatient"
                  :saved="edit.basic" 
                  @click="save_basic"/>
                <table class="table is-narrow">
                  <tr class="">
                    <th width="150">First Name</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.first_name }}</span>
                      <input 
                        v-else 
                        v-model="user.first_name" 
                        class="input is-small" 
                        type="text">
                    </td>
                  </tr>
                  <tr class="">
                    <th>Last Name</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.last_name }}</span>
                      <input 
                        v-else 
                        v-model="user.last_name" 
                        class="input is-small" 
                        type="text">
                    </td>
                  </tr>
                  <tr class="">
                    <th>Other Name</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.middle_name }}</span>
                      <input 
                        v-else 
                        v-model="user.middle_name" 
                        class="input is-small" 
                        type="text">
                    </td>
                  </tr>
                  <tr class="">
                    <th>Date of Birth</th>
                    <td>
                      <span v-if="!edit.basic">{{ [ user.dob, "YYYY-MM-DD" ] | moment("Do MMMM, YYYY") }}</span>
                      <input
                        v-else 
                        v-model="user.dob" 
                        class="input is-small" 
                        type="date">
                    </td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.email }}</span>
                      <input 
                        v-else 
                        v-model="user.email" 
                        class="input is-small" 
                        type="email">
                    </td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.gender | ucfirst }}</span>
                      <span 
                        v-else 
                        class="select is-small">
                        <select
                          v-model="user.gender">
                          <option 
                            value="0" 
                            disabled>Select Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Address</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.address }}</span>
                      <textarea 
                        v-else 
                        v-model="user.address" 
                        rows="5" 
                        class="textarea"/>
                    </td>
                  </tr>
                  <tr>
                    <th>City</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.city }}</span>
                      <input 
                        v-else 
                        v-model="user.city" 
                        class="input is-small" 
                        type="text">
                    </td>
                  </tr>
                  <tr>
                    <th>State</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.state }}</span>
                      <input 
                        v-else 
                        v-model="user.state" 
                        class="input is-small" 
                        type="text">
                    </td>
                  </tr>
                  <tr>
                    <th>Marital Status</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.marital_status | ucfirst }}</span>
                      <template v-else>
                        <input 
                          v-model="user.marital_status" 
                          type="radio" 
                          name="m_status" 
                          value="single"> Single
                        <input 
                          v-model="user.marital_status" 
                          type="radio" 
                          name="m_status" 
                          value="married" > Married
                      </template>
                    </td>
                  </tr>
                  <tr>
                    <th>Phone Number</th>
                    <td>
                      <span v-if="!edit.basic">{{ user.phone }}</span>
                      <input 
                        v-else 
                        v-model="user.phone" 
                        class="input is-small" 
                        type="Number">
                    </td>
                  </tr>
                  <tr>
                    <th>ID</th>
                    <td>
                      {{ user.chcode }}
                      <button 
                        class="button is-small is-text" 
                        @click="copyTextToClipboard(user.chcode)">COPY</button>
                    </td>
                  </tr>
                </table>
              </section>
            </accordion>
            <!-- Next of Kin -->
            <accordion class="menu">
              <template slot="heading">Next of Kin</template>
              <section 
                slot="content" 
                class="content">
                <save-edit-button 
                  v-if="isPatient"
                  :saved="edit.basic"
                  @click="save_basic"/>
                <div v-if="!edit.basic">
                  <h1 class="title is-5 mb-10">{{ user.nok_name }}</h1>
                  <p><b>Email Address:</b> {{ user.nok_email }}</p>
                  <p><b>Phone Number:</b> {{ user.nok_phone }}</p>
                  <p><b>Address:</b> {{ user.nok_address }}</p>
                </div>
                <div v-else>
                  <div class="field">
                    <input 
                      v-model="user.nok_name" 
                      type="text" 
                      placeholder="Full Name" 
                      class="input">
                  </div>
                  <div class="field">
                    <input 
                      v-model="user.nok_email" 
                      placeholder="Email Address" 
                      type="email" 
                      class="input">
                  </div>
                  <div class="field">
                    <input 
                      v-model="user.nok_phone"
                      placeholder="Phone Number"
                      type="text" 
                      class="input">
                  </div>
                  <div class="field">
                    <select-state
                      :value="user.nok_state"
                      @change="e => user.nok_state = e"/>
                    <select-city 
                      :state="user.nok_state" 
                      :value="user.nok_city"
                      @change="e => user.nok_city = e"/>
                  </div>
                  <div class="field">
                    <textarea 
                      v-model="user.nok_address" 
                      class="textarea" 
                      type="text" 
                      placeholder="Address"/>
                  </div>
                </div>
              </section>
            </accordion>
            <!-- Emergency Contact -->
            <accordion :show="false">
              <template slot="heading">Emergency Hospital</template>
              <section slot="content">
                <save-edit-button 
                   v-if="isPatient"
                  :saved="edit.emergency" 
                  @click="save_emerg" />
                <div v-if="!edit.emergency">
                  <span v-if="!user.emergency_hospital_name">No Emergency Address Yet</span>
                  <template v-else>
                    <h3 class="mb-5">{{ user.emergency_hospital_name }}</h3>
                    <p style="opacity: 0.8">{{ user.emergency_hospital_address }}</p>
                  </template>
                </div>
                <div v-else>
                  <div class="field">
                    <input 
                      v-model="user.emergency_hospital_name" 
                      class="input" 
                      type="text" 
                      placeholder="Name">
                  </div>
                  <div class="field">
                    <textarea 
                      v-model="user.emergency_hospital_address" 
                      class="textarea" 
                      placeholder="Address" 
                      row="5" />
                  </div>
                </div>
              </section>
            </accordion>
          </div>
          <div slot="p2">
            <h3 class="menu-label">Annual Medical Check</h3>
            <MedicalCheckup v-if="pager.page === 1" :can-edit="!isPatient"/>
          </div>
          <!-- MEDICAL HISTORY -->
          <section slot="p3">
            <div class="menu-label">Medical History</div>
            <MedicalHistory v-if="pager.page === 2" :can-edit="true"/>
          </section>
          <!-- Immunization -->
          <div slot="p4">
            <div class="menu-label">IMMUNIZATIONS</div>
            <Immunizations v-if="pager.page === 3" :can-edit="true"/>
          </div>
          <!-- ALLERGIES -->
          <div slot="p5">
            <div class="menu-label">ALLERGIES</div>
            <Allergies v-if="pager.page === 4" :can-edit="true"/>
          </div>
          <!-- FAMILY MEDICAL HISTORY -->
          <div slot="p6">
            <div class="menu-label">FAMILY MEDICAL HISTORY</div>
            <FamilyMedicalRecords :can-edit="true"/>
          </div>
          <!-- HOSPITALIZATION -->
          <div slot="p7">
            <div class="menu-label">HOSPITALIZATION</div>
            <Hospitalizations />
          </div>
          <!-- HEALTH LOGS -->
          <div slot="p8">
            <div class="menu-label">HEALTH LOG</div>
            <table class="table is-fullwidth">
              <tr>
                <th width="150">Date</th>
                <th>Nature of Health Problem</th>
              </tr>
              <tr>
                <td>2018-30-05</td>
                <td>Dr Patrick Odunze has accepted to view your Medical Profile</td>
              </tr>
            </table>
          </div>
          <!-- EMERGENCY CONTACT -->
          <div slot="p9">
            <div class="menu-label">EMERGENCY CONTACTS</div>
            <EmergencyContacts :can-edit="isPatient"/>
          </div>
          <!-- HOSPITAL CONTACTS -->
          <div slot="p10">
            <div class="menu-label">HOSPITAL CONTACTS</div>
            <HospitalContacts :can-edit="isPatient"/>
          </div>
          <!-- HEALTH INSURANCE PROVIDERS -->
          <div slot="p11">
            <div class="menu-label">HEALTH INSURANCE PROVIDER</div>
            <HealthInsuranceProvider :can-edit="isPatient"/>
          </div>
        </pager>
      </template>
    </profile-grid>
  </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import EditProfile from '@/Mixins/EditProfile.js'
import ProfileGrid from '@/components/ProfileGrid.vue'
import Allergies from '@/components/Allergies.vue'
import Immunizations from '@/components/Immunizations.vue'
import MedicalHistory from '@/components/MedicalHistory.vue'
import MedicalCheckup from '@/components/MedicalCheckup.vue'
import HospitalContacts from '@/components/HospitalContacts.vue'
import EmergencyContacts from '@/components/EmergencyContacts.vue'
import HealthInsuranceProvider from '@/components/HealthInsuranceProvider.vue'
import FamilyMedicalRecords from '@/components/FamilyMedicalRecords.vue'
import Hospitalizations from '@/components/Hospitalizations.vue'

export default {
	name: 'Profile',
	components: {
		ProfileGrid, HealthInsuranceProvider, MedicalCheckup,
    Hospitalizations, HospitalContacts, Allergies, 
    MedicalHistory, EmergencyContacts, FamilyMedicalRecords,
    Immunizations
	},
	mixins: [EditProfile],
	data() {return {
		page: 0,
		edit: {
			allergy: {},
			immunization: {},
			basic: false,
			emergency: false,
			avatarUrl: '/api/patient/profile/update/image',
			url: '/api/patient/profile/update',
			whiteList: [
				'first_name',
				'middle_name',
				'last_name',
				'avatar',
				'email',
				'password',
				'dob',
				'gender',
				'phone',
				'address',
				'city',
				'state',
				'country',
				'religion',
				'marital_status',
				'nok_name',
				'nok_phone',
				'nok_email',
				'nok_address',
				'nok_city',
				'nok_state',
				'emergency_hospital_address',
				'emergency_hospital_name',
				'nok_country',
				'nok_relationship'
			],
		},
		records: { hospitalization: [] },
	}},
	computed: {
    user() {
      return this.accountType === 'doctor' 
        ? this.patient
        : this.$parent.user
    },
    isPatient() { 
      return this.accountType === 'patient' 
    },
    ...mapGetters(['accountType']),
    ...mapState('manage_patient', {
      patient: 'currentPatient',
      patients: 'patients'
    }),
	},
  watch: {
    patients(a, b) {
      console.log('Updated the Patients', a, b)
      this.setAsDoctor()
    }
  },
	created () {
		document.title = 'Profile | CleanHelt'
    this.accountType !== 'doctor' || this.setAsDoctor()
	},
	methods: {
    setAsDoctor() {
      const { patient_id } = this.$route.params
      if (this.patients.length === 0) return
      this.$store.commit('manage_patient/set_current_patient', patient_id)
    }
  }
}
</script>