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
        <span>{{ user.full_name }}</span>
        <img 
          :src="$root.avatar" 
          alt="" 
          class="avatar ml-15">
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
            to="/patients" 
            icon="osf osf-client-alt-white" 
            name="Clients"/>
          <custom-link 
            to="/profile" 
            icon="osf osf-doctor-white" 
            name="Profile"/>
        </ul>
      </nav>
      <footer>
        <ul class="is-small">
          <li><a @click.prevent="logout"><i class="osf osf-back-alt-white"/> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-forum-white"/> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <!-- <keep-alive :exclude="['Patients']"> -->
          <router-view/>
        <!-- </keep-alive> -->
      </section>

      <aside 
        id="osq-logs" 
        :class="{collapse: $root.sidebars.notif}">
        <router-view 
          id="osq-logs-content" 
          name="logBar"/>
      </aside>
    </section>
  </main>
</template>

<script>
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'
import { mapState } from 'vuex'

export default {
	name: 'Doctor',
	mixins: [LoggedIn],
	props: {
		id: {type: String, required: true }
	},
	router: routes.doctor,
	data() {return {
		settings : {
			profile: { route: '/api/doctor/profile', key: 'doctor' },
			patients: { route : '/api/doctor/patients', key: 'patients'}
		}
	}}, // comes with all mutations and getters
	computed: {
		...mapState(['pendingHospitals', 'sentHospitals', 'hospitals'])
	},
	created() {
		this.$store.dispatch('doctor/fetchHospitals')
		this.$store.dispatch('doctor/fetchPendingHospitals')
		this.$store.dispatch('doctor/fetchSentHospitals')
	},
	methods: {}
}
</script>
