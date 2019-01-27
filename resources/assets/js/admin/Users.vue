<template>
  <section id="all-users">
    <div class="content-top-bar">
      <h3>
        <span>All Clients </span>
      </h3>
    </div>
    <section class="card is-rounded mb-10">
      <div class="card-header">      
        <search-box 
          v-model="searchString" 
          style="width: 300px" 
          placeholder="Search CHCODE" />
      </div>
      <div class="tabs">
        <ul class="py-10">
          <li 
            v-for="(type, name, index) in client_types" 
            :key="index" 
            :class="{'is-active': current == index}" 
            @click="current=index">
            <a href="#">
              <i
                :class="[type.icon]"
                class="icon"/>
              <span>{{ name }}</span> 
            </a>
          </li>
        </ul>
      </div>
      <pager 
        :current="current" 
        style="height: 68vh"
        align="top">
        <!-- PATIENTS_TABLE -->
        <div 
          slot="p1" 
          class="px-15">
          <table 
            class="table is-small is-hoverable is-fullwidth" 
            style="font-size: smaller">
            <tr>
              <th>CH Code</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
            <tr 
              v-for="(record, index) in searchFilter(models.patients.data)" 
              :key="index">
              <td>{{ record.chcode }}</td>
              <td>{{ record.name }}</td>
              <td>{{ record.phone }}</td>
              <td>{{ record.email }}</td>
              <td>
                <button 
                  class="button is-normal is-small" 
                  @click="showModal('PATIENT', record.chcode)">View</button>
                <span 
                  v-if="record.active == 1" 
                  class="tag is-success">Active</span>
                <span 
                  v-if="record.active == 0" 
                  class="tag is-danger">Inactive</span>
              </td>
            </tr>
          </table>
        </div>
        <!-- DOCTORS_TABLE -->
        <div 
          slot="p2" 
          class="px-15">
          <table 
            class="table is-hoverable is-fullwidth">
            <tr>
              <th>CH Code</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Account Status</th>
              <th>Actions</th>
            </tr>
            <tr 
              v-for="(record, index) in searchFilter(models.doctors.data)" 
              :key="index">
              <td>{{ record.chcode }}</td>
              <td>Dr. {{ record.name }}</td>
              <td>{{ record.email }}</td>
              <td>
                <span 
                  v-if="!!record.profile.active" 
                  class="tag is-success">
                  unlocked
                </span>
                <span 
                  v-else 
                  class="tag is-danger">
                  locked
                </span>
              </td>
              <td>
                <div class="buttons">
                  <button 
                    class="button is-normal is-small" 
                    @click="showModal('DOCTOR', record.chcode)">
                    View
                  </button>
                  <button 
                    v-if="!!record.profile.active" 
                    title="Lock"
                    class="button is-small" 
                    @click="lock('DOCTOR', record)">
                    <i class="ti ti-unlock"/>
                  </button>
                  <button 
                    v-else 
                    title="Unlock" 
                    class="button is-small"
                    @click="unlock('DOCTOR', record)">
                    <i class="ti ti-lock"/>
                  </button>
                  <button 
                    v-if="record.validation" 
                    class="button is-small  is-success">
                    verify
                  </button>
                  <button 
                    v-if="!record.validation" 
                    :title="`click to verify Dr. ${record.name}`"
                    class="button is-small is-danger"
                    @click="verifyDoctor(record)">
                    not verified
                  </button>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div 
          slot="p3" 
          class="px-15">
          <!-- pharmacies table -->
          <table 
            class="table is-small is-hoverable is-fullwidth" 
            style="font-size: smaller">
            <tr>
              <th>CH Code</th>
              <th>Name</th>
              <th>Telephone</th>
              <th>Email</th>
              <th>State</th>
              <th>Status</th>
            </tr>
            <tr 
              v-for="(record, index) in searchFilter(models.pharmacies.data)" 
              :key="index">
              <td>{{ record.chcode }}</td>
              <td>{{ record.name }}</td>
              <td>{{ record.phone }}</td>
              <td>{{ record.email }}</td>
              <td>{{ record.state }}</td>
              <td>
                <button 
                  class="button is-normal is-small" 
                  @click="showModal('PHARMACY', record.chcode)">View</button>
                <span 
                  v-if="record.active == 1" 
                  class="tag is-success">verified</span>
                <span 
                  v-if="record.active == 0" 
                  class="tag is-danger">inactive</span>
              </td>
            </tr>
          </table>
        </div>
        <div 
          slot="p4" 
          class="px-15">
          <table 
            class="table is-small is-hoverable is-fullwidth" 
            style="font-size: smaller">
            <tr>
              <th>CH Code</th>
              <th>Name</th>
              <th>Telephone</th>
              <th>Email</th>
              <th>State</th>
              <th>Status</th>
            </tr>
            <tr 
              v-for="(record, index) in searchFilter(models.labs.data)" 
              :key="index">
              <td>{{ record.chcode }}</td>
              <td>{{ record.name }}</td>
              <td>{{ record.phone }}</td>
              <td>{{ record.email }}</td>
              <td>{{ record.state }}</td>
              <td>
                <span 
                  v-if="record.active == 1" 
                  class="tag is-success">verified</span>
                <span 
                  v-if="record.active == 0" 
                  class="tag is-info">inactive</span>
                  <!-- <button @click="showModal('LABORATORY', record.chcode)" class="button is-normal is-small">View</button> -->
              </td>
            </tr>
          </table>
        </div>
        <div 
          slot="p5" 
          class="px-15">
          <table 
            class="table is-small is-hoverable is-fullwidth" 
            style="font-size: smaller">
            <tr>
              <th>CH Code</th>
              <th>Name</th>
              <th>Telephone</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
            <tr 
              v-for="(record, index) in searchFilter(models.hospitals.data)" 
              :key="index">
              <td>{{ record.chcode }}</td>
              <td>{{ record.name }}</td>
              <td>{{ record.phone }}</td>
              <td>{{ record.email }}</td>
              <td>
                <button 
                  class="button is-normal is-small" 
                  @click="showModal('HOSPITAL', record.chcode)">View</button>
                <span 
                  v-if="!!record.active == true" 
                  class="button is-small is-success" 
                  @click="lock('HOSPITAL', record)">
                  Active
                </span>
                <span 
                  v-else 
                  class="button is-small is-danger" 
                  @click="unlock('HOSPITAL', record)">
                  Inactive
                </span>
              </td>
            </tr>
          </table>
        </div>
      </pager>
    </section>

    <modal 
      :show-header="true" 
      :show="modal" 
      @closed="modal = false">
      <section>
        <ProfileLoader 
          v-if="modal"
          :of="model"
          :chcode="preview" 
          by="ADMIN"/>  
      </section>
    </modal>
  </section>
</template>

<script>
  import axios from 'axios'
  import { mapState, mapActions } from 'vuex'
  
  const lockUrlMap = {
    modelMaps: Object.freeze({
      DOCTOR: '/api/admin/doctors/{chcode}/deactivate',
      LABORATORY: '/api/admin/laboratories/{chcode}/deactivate',
      PATIENT: '/api/admin/patients/{chcode}/deactivate',         
    }),
    __proto: { 
      urlIsValid() { 
        return this.isValid 
      }, 
      url(chcode) { 
        return this._url.replace('{chcode}', chcode)
      },
      getUnlockUrl(chcode) {
        return this._url.replace('deactivate', 'activate').replace('{chcode}', chcode)
      },
      _url: '' ,
      isValid: false
    },
    find(model) {
      return Object.assign(this.__proto, {
        isValid: Object.keys(this.modelMaps).includes(model), 
        _url: this.modelMaps[model]
      })
    }
  }

  export default {
    name: 'AllUsers',
    data() {return {
      current: 0,
      modal: false,
      model: 'PATIENT',
      client_types: {
        Patients: {icon: 'osf osf-client-alt'},
        Doctors: {icon: 'osf osf-doctor'},
        Pharmacy: {icon: 'osf osf-pharmacy'},
        Laboratory: {icon: 'osf osf-lab'},
        Hospital: {icon: 'osf osf-hospital'},
      },
      preview: false,
      searchString: '',
    }},
    computed: {
      ...mapState(['models']),
      model_keys() { return Object.keys(this.models) }
    },
    mounted() {
      const {personalify, addMethods} = this

      this.model_keys.map((model) => {
        this.fetch(model).then((res) => {
          let accounts = res.data.data.data
          const users_info = accounts.map((d) => personalify(d)).map(addMethods)
          this.$set(this.models, model, {data: users_info})
        })
      })
    },
    customMethods: {
      setActive(state = false) {
        (/^CHD/.test(this.chcode)) ? (this.profile.active = state) 
        // : (/^CHH/.test(this.chcode)) ? (this.active = false) 
        : (this.active = state)
      },
      activate() {
        this.setActive(true)
      },
      deactivate() {
        this.setActive(false)
      },
    },
    methods: {
      ...mapActions(['fetch']),

      addMethods(account) {
        account = _.extend(Object.create(this.$options.customMethods), account)
        console.assert(!Object.keys(account).includes('activate'), 'Error! AddMethods not appended to Object.')

        return account
      },
      searchFilter(e) {
        return (e ||  []).filter(e => 
          e.chcode.toLowerCase()
            .includes(this.searchString.toLowerCase())
        )
      },
      verifyDoctor(doctor) {
        doctor.validation = true
        axios.patch(`/api/admin/doctors/verify/${doctor.chcode}`).catch((res) => {
          doctor.validation = false
          this.$notify({
            group: 'main', text: 'Doctor verification failed!',
            type: 'error'
          })
        })
      },
      lock(model, account) {
        account.deactivate()
        const lockState = lockUrlMap.find(model)
        !lockState.urlIsValid() ||
          axios.patch(lockState.url(account.chcode)).catch(err => {
          account.activate()
        })
      },
      unlock(model, account) {
        account.activate()
        const lockState = lockUrlMap.find(model)
        !lockState.urlIsValid() ||
          axios.patch(lockState.getUnlockUrl(account.chcode)).catch(err => {
          account.deactivate()
        })
      },
      showModal(model, chcode) {
        this.model = model
        this.preview = chcode
        this.modal = true
      }
    }
  }
</script>
