<template>
  <main 
    v-cloak 
    id="hospital" 
    class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img 
          style="height: 25px" 
          src="@/../assets/logo-full@4.png" 
          alt="">
      </div>
    </header>

    <aside 
      :class="{collapse: sidebars.nav}" 
      @click="handleAutoCollapse"
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
            to="/doctors" 
            icon="osf osf-doctor-white" 
            name="Doctors "/>
          <custom-link 
            to="/profile" 
            icon="osf osf-hospital-white" 
            name="Profile"/>
          <custom-link 
            to="/settings" 
            icon="osf osf-settings-white" 
            name="Settings"/>
        </ul>
      </nav>
      
      <footer>
        <ul class="">
          <li><a @click.prevent="logout"><i class="osf osf-back-alt-white"/> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-forum-white"/> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content"> 
        <keep-alive :exclude="['Modal', 'HospitalProfile', 'Patients']">
          <router-view/>
        </keep-alive>
      </section>

      <aside 
        id="osq-logs" 
        :class="{collapse: sidebars.notif}">
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
import DashboardActions from '@/Mixins/DashboardActions'

export default {
  name: 'Hospital',
  router: routes.hospital,
  mixins: [LoggedIn, DashboardActions],
  data: () => ({
    settings: {
      profile: {route: '/api/hospital/profile', key: 'hospital'},
    }
  }),
}
</script>
