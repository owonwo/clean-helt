<template>
  <main 
    v-cloak 
    class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <button 
          class="osq-navbar-toggle mr-5" 
          @click="toggleSidebar">
          <i class="ti ti-menu"/>
        </button>
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
        <span>{{ user.first_name }}</span>
      </div>
    </header>

    <aside 
      :class="{collapse: sidebars.nav}" 
      class="osq-sidebar">
      <nav>
        <ul @click="handleAutoCollapse">
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
        :class="{collapse: sidebars.notif}">
        <router-view 
          id="osq-logs-content" 
          name="logBar" 
          @toggle-notif-bar="toggleNotification()"/>
      </aside>
    </section>
  </main>
</template>

<script>
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'
import DashboardActions from '@/Mixins/DashboardActions'

export default {
  name: 'Patient',
  mixins: [LoggedIn, DashboardActions],
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
    }
  },
  methods: {}
}
</script>
