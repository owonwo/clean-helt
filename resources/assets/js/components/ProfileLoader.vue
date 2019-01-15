<template>
  <section>
    <div 
      v-preload 
      v-if="isLoading"
      class="block is-rounded mx-15 my-5 mb-0" 
      style="height:10px; border-radius: 0"/>

    <!-- PHARMACY -->
    <template v-if="!isLoading && $props.of === 'PHARMACY'">
      <table class="table is-borderless is-fullwidth">
        <tr>
          <th>Name:</th>
          <td>{{ user.name }}</td>
        </tr>
        <tr>
          <th>Email:</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>Phone:</th>
          <td>{{ user.phone }}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{ user.address }}</td> 
        </tr>
        <tr>
          <th>City</th>
          <td>{{ user.city }}</td> 
        </tr>
        <tr>
          <th>State</th>
          <td>{{ user.state }}</td>
        </tr>
        <tr>
          <th>Country</th>
          <td>{{ user.country }}</td>
        </tr>
        <tr>
          <th>Registration No.:</th>
          <td>{{ user.chief_pharmacist_reg }}</td>
        </tr>
        <tr>
          <th>ID</th>
          <td>
            {{ user.chcode }}
            <button class="button is-small is-text">COPY</button>
          </td>
        </tr>
      </table>
    </template>

    <!-- DOCTOR -->
    <template v-if="!isLoading && $props.of === 'DOCTOR'">
      <table class="table is-borderless is-fullwidth">
        <tr>
          <th width="20%">Full Name:</th>
          <td>{{ user.full_name }}</td>
        </tr>
        <tr>
          <th>Specialization:</th>
          <td>{{ user.specialization | ucfirst }}</td>
        </tr>
        <tr>
          <th>Email:</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>Gender:</th>
          <td>{{ user.gender | ucfirst }}</td>
        </tr>
        <tr>
          <th>MDCN:</th>
          <td>{{ user.folio }}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{ user.profile.address }}</td> 
        </tr>
        <tr>
          <th>State</th>
          <td>{{ user.profile.state }}</td>
        </tr>
        <tr>
          <th>ID</th>
          <td>
            {{ user.chcode }}
          </td>
        </tr>
      </table>
    </template>

    <!-- HOSPITAL -->
    <template v-if="!isLoading && $props.of === 'HOSPITAL'">
      <section slot="content">
        <table class="table is-borderless">
          <tr class="">
            <th width="150">Name</th>
            <td>{{ user.name }}</td>
          </tr>
          <tr class="">
            <th>Email</th>
            <td>{{ user.email }}</td>
          </tr>
          <tr> 
            <th>Telephone</th>
            <td>{{ user.phone }}</td>
          </tr>
          <tr>
            <th>Address</th>
            <td>{{ user.address }}</td>
          </tr>
          <tr>
            <th>ID</th>
            <td>
              {{ user.chcode }} 
              <button class="button is-small is-text">COPY</button>
            </td>
          </tr>
          <tr>
            <th>Website</th>
            <td>{{ user.website || 'http://' }}</td>
          </tr>
        </table>
      </section>
    </template>

    <!--  PATIENT -->
    <template v-if="!isLoading && $props.of === 'PATIENT'">
      <accordion :show="true">
        <template slot="heading">Basic</template>
        <section slot="content">
          <table class="table is-narrow">
            <tr class="">
              <th width="150">Full Name</th>
              <td>{{ user.full_name }}</td>
            </tr>
            <tr class="">
              <th>Date of Birth</th>
              <td>{{ user.dob | moment('calendar', 'July 10, 1998') }}</td>
            </tr>
            <tr>
              <th>Email:</th>
              <td>{{ user.email }}</td>
            </tr>
            <tr>
              <th>Gender</th>
              <td>{{ user.gender | ucfirst }}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{ user.address }}</td>
            </tr>
            <tr>
              <th>ID</th>
              <td>
                {{ user.chcode }}
                <button class="button is-small is-text">COPY</button>
              </td>
            </tr>
          </table>
        </section>
      </accordion>
      <accordion>
        <template slot="heading">Emergency Hospital</template>
        <section slot="content">
          <div v-if="!!user.emergency_hospital_name">
            <h3 class="m-0">{{ user.emergency_hospital_name }}</h3>
            <b class="m-0">Address:</b>
            <p>{{ user.emergency_hospital_address }}</p>
          </div>
          <div v-else>
            NOT PROVIDED YET!
          </div>
        </section>
      </accordion>
      <accordion class="menu">
        <template slot="heading">Next of Kin
        </template>
        <section 
          slot="content" 
          class="content">
          <h1 class="title is-5 mb-0">{{ user.nok_name }}</h1>
          <div>
            <small>Email Address: {{ user.nok_email }}</small>
          </div>
          <div>
            <small>Phone Number: {{ user.nok_phone }}</small>
          </div>
        </section>
      </accordion>
    </template>
  </section>
</template>

<script>
import axios from 'axios'

export default {
	name: 'ProfielLoader',
	props: ['of', 'by', 'chcode'],
	data() {
		return {
			isLoading: false,
			user: {},
				models: {
					ADMIN: {
						PATIENT: '/api/admin/patients/{chcode}',
						DOCTOR: '/api/admin/doctors/{chcode}',
						HOSPITAL: '/api/admin/hospitals/{chcode}',
						PHARMACY: '/api/admin/pharmacies/{chcode}',
						LABORATORY: '/api/admin/laboratories/{chcode}',
					},
			},
		}
	},
	mounted() {
		this.fetchData()
	},
	methods: {
		fetchData() {
			const {getUrl, personalify, $props: {chcode}} = this

			this.isLoading = true
			!this.testChCode(chcode) ||
			axios.get(getUrl())
				.then(({data}) => {
					this.user = personalify(data.data)
					this.isLoading = false
				})
				.catch((err) => {
					this.logError(err)
					this.isLoading = false
				})
		},
		getUrl() {
			let {by, of, chcode} = this.$props
			return this.models[by][of].replace('{chcode}', chcode)
		}
	},
}
</script>
