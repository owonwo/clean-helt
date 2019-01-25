<template>
  <section>
    <div class="profile-settings">
      <aside class="osq-sidenav">
        <div class="menu">
          <div class="menu-label">
            <i class="ti icon ti-settings"/> Settings
          </div>
          <ul 
            v-pager-controls.prevent="{activeClass: 'active'}" 
            class="menu-list">
            <li v-if="$store.getters.isAdult">
              <a href="#children">Children</a>
            </li>
            <li><a href="#notifications">Notification</a></li>
          </ul>
        </div>
      </aside>
        
      <section class="content">
        <pager :current="page"> 
          <div 
            slot="p1">
            <span class="menu-label">Manage Children</span>
            <Children />
          </div>
          <div 
            slot="p2" 
            class="p-10">
            <toggle-switch 
              :value="false" 
              size="sm"/>
            <span class="menu-label">Notifications</span>
            <p 
              style="font-size: small" 
              class="is-small">I want to receive notifications.</p>
          </div>
        </pager>
      </section>
    </div>
  </section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import Children from '@/patients/Children.vue'
import ToggleSwitch from '@/components/ToggleSwitch.vue'

export default {
  name: 'PatientSettings',
  components: {Modal, ToggleSwitch, Children},
  data() {return {
    page: 0,
    notification_state: true,
  }},
  mounted: () => { document.title = 'Settings Dashboard | CleanHelt' },
  methods: {
    setPage(page = 0) {
      this.page = page
    }
  }
}
</script>
