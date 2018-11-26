<template>
  <section class="p-15">
    <div class="card card-content is-paddingless">
      <div class="osq-two-columns">
        <aside class="osq-sidenav p-10">
          <div class="menu">
            <div class="menu-label">
              <i class="ti icon ti-settings"/> Settings
            </div>
            <ul 
              v-pager-controls.prevent="{activeClass: 'active'}" 
              class="menu-list">
              <li 
                v-for="(name, index) in ['Notification', 'Share Logs', 'Bookmarks']" 
                :key="index">
                <a href="#">{{ name }}</a>
              </li>
            </ul>
          </div>
        </aside>

        <section class="content">
          <pager :current="page">
            <div 
              slot="p1" 
              class="p-10">
              <toggle-switch 
                :value="false" 
                size="sm"/>
              <span class="menu-label">Notifications</span>
              <p 
                style="font-size: small" 
                class="is-small">I want to receive notifications.</p>
            </div>
            <div 
              slot="p2"
              class="p-10">
              <span class="menu-label">Shares</span>
            </div>
            <div 
              slot="p3" 
              class="p-10">
              <span class="menu-label">Bookmarks</span>
            </div>
          </pager>
        </section>
      </div>
    </div>
  </section>
</template>

<script>
import Modal from '@/components/Modal.vue'
import ToggleSwitch from '@/components/ToggleSwitch.vue'
import HealthInsuranceProvider from '@/components/HealthInsuranceProvider'

export default {
	name: 'PatientSettings',
	components: {Modal, ToggleSwitch, HealthInsuranceProvider},
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
