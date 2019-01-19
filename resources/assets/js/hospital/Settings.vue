<template>
  <section class="p-15">
    <div class="card is-rounded card-content is-paddingless">
      <div class="osq-two-columns">
        <aside class="osq-sidenav p-10">
          <div class="menu">
            <div class="menu-label"><i 
              class="ti icon ti-settings" 
              style="font-size: 1.5em;vertical-align: middle;"/> Settings</div>
            <ul 
              v-pager-controls.prevent="{activeClass: 'active'}" 
              class="menu-list">
              <li v-for="(name, index) in ['Notification','Manage Doctors']"><a href="#">{{ name }}</a></li>
            </ul>
          </div>
        </aside>
        <section class="content">
          <pager :current="page">
            <div 
              slot="p1" 
              class="p-10">
              <div class="menu-label">NOTIFICATIONS</div>
              <toggle-switch 
                :value="false" 
                size="sm" />
              <span>Notifications</span>
              <p 
                style="font-size: small" 
                class="is-small">I want to receive notifications.</p>
            </div>
            <v-scrollbar 
              slot="p2" 
              class="p-10">
              <!-- preloader -->
              <div 
                v-preload 
                v-if="!isLoaded"
                class="block is-rounded mx-15 my-5 mb-0" 
                style="height:10px;border-radius: 0" />
              <!-- doctors table -->
              <table class="table is-hoverable is-fullwidth">
                <tr>
                  <th>Full Name</th>
                  <th>Options</th>
                </tr>
                <tr v-for="(doctor, index) in orderDoctor" :key="index">
                  <td>
                    Dr. {{ doctor.first_name }} {{ doctor.last_name }}
                    <span 
                      v-if="!doctor.status" 
                      class="tag ml-15">pending</span>
                    <br>
                  </td>
                  <td>
                    <span class="osq-text-green mr-15">{{ doctor.chcode }}</span> {{ doctor.phone }}
                  </td>
                  <td>
                    <button 
                      v-if="doctor.status" 
                      class="button is-hovered-danger has-no-motion is-outlined is-rounded" 
                      @click="modal.remove = true">
                      <i class="ti ti-trash"/> delete
                    </button>
                    <button 
                      v-if="!doctor.status" 
                      class="button is-rounded has-no-motion is-outlined is-success" 
                      @click="acceptDoctor(doctor)">
                      <i class="ti ti-check"/> accept
                    </button>
                  </td>
                </tr>
              </table>
              <div class="has-text-right">
                <button 
                  class="md-btn-circle has-no-motion" 
                  @click="modal.add = true">
                  <i class="ti icon ti-plus"/>
                </button>
              </div>
            </v-scrollbar>
          </pager>
        </section>
      </div>
      <!-- remove doctor modal -->
      <modal 
        :show="modal.remove" 
        size="sm" 
        @closed="(modal.remove = false)">
        <div class="content is-center">
          <h5 class="title has-text-centered is-6">
            <div>
              <i 
                class="ti ti-key" 
                style="font-size: 4em"/>
            </div>
            INSERT PASSWORD
          </h5>
          <div class="field">
            <input 
              v-model="password" 
              type="password" 
              class="input" 
              placeholder="Password">
          </div>
        </div>
        <div 
          slot="modal-footer" 
          class="column is-fullwidth">
          <button 
            class="button is-fullwidth is-primary" 
            @click="checkPassword()">
            PROCEED
          </button>
        </div>
      </modal>
      <!-- add doctor modal -->
      <modal 
        :show="modal.add" 
        size="sm" 
        @closed="(modal.add = false)">
        <div class="content is-center">
          <h5 class="title has-text-centered is-6">
            <div>
              <i 
                class="osf osf-doctor" 
                style="font-size: 4em"/>
            </div>
            ADD DOCTOR
          </h5>
          <AddServiceProvider 
            model="HOSPITAL" 
            @success="fetchDoctors" @error="handleError"/>
        </div>
      </modal>
    </div>
  </section>
</template>
<script>
import { mapActions, mapGetters, mapState } from 'vuex'
import ToggleSwitch from '@/components/ToggleSwitch.vue'

export default {
    name: 'HospitalSettings',
    components: { ToggleSwitch },
    data() {
        return {
            page: 0,
            password: '',
            modal: { add: false, remove: false, },
            notification_state: true,
        }
    },
    computed: {
        ...mapState('hospital', ['isLoaded', 'pendingDoctors']),
        ...mapGetters('hospital', { doctors: 'combined', orderDoctor: 'sortByStatus' }),
    },
    created() {
       
    },
    activated () { 
        document.title = 'Settings | CleanHelt'

        this.$store.dispatch('hospital/FETCH_DOCTORS')
        this.$store.dispatch('hospital/FETCH_PENDING_DOCTORS')
    },
    methods: {
        ...mapActions('hospital', ['fetchPendingDoctors', 'fetchDoctors']),
        setPage(page = 0) {
            this.page = page
        },
        acceptDoctor(doctor) {
            this.$store.dispatch('hospital/ACCEPT_DOCTOR', doctor)
        },
        checkPassword() {
            // this.$http.post('').then((res) => {})
        },
        revokeAccess() {
            this.modal.remove = false
        },
        handleError(error) {
          this.error_message(error)
        }
    }
}
</script>
