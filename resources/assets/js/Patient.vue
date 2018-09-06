<template>
  <main id="doctor" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
      </div>

      <div class="avatar-holder">
        <img :src="$root.avatar" alt="" class="avatar">
        <span>Kelvin Morrison</span>
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <router-link to="/dashboard" tag="li">
            <a href="#"><i class="osf osf-dashboard"></i> Dashboard</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>

          <router-link to="/services" tag="li">
            <a href="#"><i class="osf osf-department"></i> Departments</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>

          <router-link to="/profile" tag="li">
            <a href="#"><i class="osf osf-patient-white"></i> Profile</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>

          <router-link to="/Notifications" tag="li">
            <a href="#"><i class="osf osf-bell"></i> Notifications</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>

          <router-link to="/settings" tag="li">
            <a href="#"><i class="osf osf-settings"></i> Settings</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
        </ul>
      </nav>
      <footer>
        <ul class="">
          <li><a href="#"><i class="osf osf-signout"></i> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-comment"></i> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <router-view/>
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
  name: 'Patient',
  mixins: [LoggedIn],
  router: routes.patient,
  data() {return {
      settings : {
        profile: { route: `/api/patient/${this.$props.id}/patient`, key: 'patient' },
        // patients: { route : '/api/patient', key: 'patients'}
      },
  }}
}
</script>
