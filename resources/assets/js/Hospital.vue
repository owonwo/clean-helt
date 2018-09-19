<template>
  <main id="doctor" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <custom-link to="/dashboard" icon="osf osf-dashboard" name="Dashboard"/>
          <custom-link to="/patients" icon="osf osf-patient-white" name="Clients"/>
          <custom-link to="/doctors" icon="osf osf-doctor-white" name="Departments"/>
          <custom-link to="/profile" icon="osf osf-profile" name="Profile"/>
          <custom-link to="/settings" icon="osf osf-settings" name="Settings"/>
        </ul>
      </nav>
      
      <footer>
        <ul class="">
          <li><a @click.prevent="logout"><i class="osf osf-signout"></i> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-comment"></i> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content"> 
        <keep-alive :exclude="['Patients','DoctorDirectory']">
          <router-view/>
        </keep-alive>
      </section>

      <aside id="osq-logs" :class="{collapse: $root.sidebars.notif}">
        <router-view id="osq-logs-content" name="logBar"/>
      </aside>
    </section>
  </main>
</template>

<script>
import routes from './routes';
import LoggedIn from '@/Mixins/LoggedIn';

export default {
  name: 'Hospital',
  router: routes.hospital,
  mixins: [LoggedIn],
  data() {return {
    settings: {
      profile: {route: "/api/hospital/profile", key: 'hospital'},
      patients: {route: "/api/hospital/patients", key: 'patients'},
    }
  }},
  methods: {
    timeout(duration) {
      return new Promise((resolve) => setTimeout(resolve, duration));
    },
    // gets all the hospital doctors
    async getDoctors() {
      let [doctors] = await Promise.all([
        this.$http.get('/api/hospital/doctors'),
        this.timeout(1000),
      ]);
      return doctors; 
    },
    async getDoctorsPending() {
        return await this.$http.get('/api/hospital/doctors/pending');
    }
  }
}
</script>
