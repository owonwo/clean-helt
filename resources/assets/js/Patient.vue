<template>
  <main 
    v-cloak 
    id="doctor" 
    class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img 
          style="height: 25px" 
          src="@/../assets/logo-full@4.png" 
          alt="">
      </div>

      <div class="avatar-holder">
        <img 
          :src="user.avatar" 
          alt="" 
          class="avatar">
        <span>{{ user.full_name }}</span>
      </div>
    </header>

    <aside 
      :class="{collapse: $root.sidebars.nav}" 
      class="osq-sidebar">
      <nav>
        <ul>
          <custom-link 
            to="/dashboard" 
            icon="osf osf-dashboard-white" 
            name="Dashboard"/> 
          <custom-link 
            to="/services" 
            icon="osf osf-department-white" 
            name="Health Services"/>
          <custom-link 
            to="/profile-shares" 
            icon="osf osf-dashboard-white" 
            name="Profile Shares"/>            
          <custom-link 
            to="/profile" 
            icon="osf osf-client-alt-white" 
            name="Profile"/>

          <custom-link 
            to="/settings" 
            icon="osf osf-settings-white" 
            name="Settings"/>
        </ul>
      </nav>
      <footer>
        <ul class="">
          <li>
            <a @click.prevent="logout">
            <i class="osf osf-back-alt-white"/> Sign Out</a>
          </li>
          <li>
            <a href="#">
            <i class="osf osf-forum-white"/> Log into Forum</a>
          </li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <router-view/>
      </section>
      
      <aside 
        id="osq-logs" 
        :class="{collapse: $root.sidebars.notif}">
        <router-view 
          id="osq-logs-content" 
          name="logBar" />
      </aside>
    </section>
  </main>
</template>

<script>
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'

export default {
	name: 'Patient',
	mixins: [LoggedIn],
	router: routes.patient,
	data() {
		return {
			settings: {
				profile: {
					route: '/api/patient/profile',
					key: 'data'
				},
				patients: {
					route: '/api/patient',
					key: 'data'
				}
			},
			shares: [],
			recordUrlMap: Object.freeze({
				labtest:'/api/patient/labtest',
				prescription: '/api/patient/prescription',
				medicalRecord: '/api/patient/medical-records',
				medicalHistory: '/api/patient/medical-history',
				immunization: '/api/patient/record/immunization',
				hospitalization: '/api/patient/record/hospitalization',
				allergy: '/api/patient/record/allergy',
			}),
		}
	},
	methods: {
		async getRecord(record_type) {
			const {recordUrlMap} = this
			if(!Object.keys(recordUrlMap).includes(record_type))
				return Promise.reject(new Error(`Invalid Patient Record Key: "${record_type}"`))
			return await this.$http.get(recordUrlMap[record_type].replace('{patient}', this.$props.id || 'invalid'))
		}
	}
}
</script>
