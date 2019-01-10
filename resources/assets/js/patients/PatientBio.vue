<template>
  <section>
    <div class="menu-label">User Information</div>
    <span 
      v-preload
			v-if="!user.id"/>
    <accordion :show="true">
      <template slot="heading">Basic</template>
      <section slot="content">
        <SaveEditButton 
          v-if="canEdit"
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
                class="button is-primary ml-5 no-motion is-small" 
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
        <SaveEditButton 
          v-if="canEdit"
          :saved="edit.basic"
          @click="save_basic"/>
        <div v-if="!edit.basic">
          <h1 class="title is-5 mb-10">{{ user.nok_name }}</h1>
          <table class="table is-narrow">
            <tr>
              <td>Email Address</td>
              <td>{{ user.nok_email }}</td>
            </tr>
            <tr>
              <td>Phone Number</td>
              <td>{{ user.nok_phone }}</td>
            </tr>
            <tr>
              <td>Address</td> 
              <td>{{ user.nok_address }}</td>
            </tr>
            <tr>
              <td>State of Origin</td> 
              <td>{{ user.nok_state }}</td>
            </tr>
          </table>
        </div>
        <div v-else>
          <wgInput 
            v-model="user.nok_name" 
            type="text" 
            placeholder="Full Name"/>
          <wgInput 
            v-model="user.nok_email" 
            placeholder="Email Address" 
            type="email"/>
          <wgInput 
            v-model="user.nok_phone"
            placeholder="Phone Number"
            type="text"/>
          <div class="field">
            <textarea 
              v-model="user.nok_address" 
              class="textarea" 
              type="text" 
              placeholder="Address"/>
          </div>
          <div class="field">
            <select-state
              v-model="user.nok_state"/>
          </div>
        </div>
      </section>
    </accordion>
    <!-- Emergency Contact -->
    <accordion :show="false">
      <template slot="heading">Emergency Hospital</template>
      <section slot="content">
        <SaveEditButton 
          v-if="canEdit"
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
  </section>
</template>

<script>
import {mapState, mapGetters} from 'vuex'
import CanLock from '@/Mixins/CanLock.js'
import EditProfile from '@/Mixins/EditProfile.js'

export default {
	mixins: [EditProfile, CanLock],
	data() {return {
		edit: {
			url: '/api/patient/profile/update',
			basic: false,
			emergency: false,
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
		}
	}},
	computed: {
		user() {
      return this.accountType === 'doctor' 
        ? this.patient
        : this.getUser
    },
    ...mapGetters(['accountType', 'getUser']),
    ...mapState('manage_patient', {
      patient: 'currentPatient',
      patients: 'patients'
    }),
	}
}
</script>
