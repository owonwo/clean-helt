<template>
  <main id="doctor" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
      </div>

      <div class="avatar-holder">
        <span>{{ $store.state.user.full_name }}</span>
        <img :src="$root.avatar" alt="" class="avatar ml-15">
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <router-link to="/dashboard" tag="li">
            <a href="#"><i class="osf osf-dashboard"></i> Dashboard</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
          <router-link to="/patients" tag="li">
            <a href="#"><i class="osf osf-patient-white"></i> Clients</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
          <router-link to="/profile" tag="li">
            <a href="#"><i class="osf osf-doctor-white"></i> Profile</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
        </ul>
      </nav>
      <footer>
        <ul class="is-small">
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
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'


export default {
    name: 'Doctor',
    props: ['id'],
    router: routes.doctor,
    mixins: [LoggedIn], // comes with all mutations and getters
    data() {return {
      settings : {
        profile: { route: '/api/doctor/profile', key: 'doctor' },
        patients: { route : '/api/doctor/patients', key: 'patients'}
      }
    }},
}
</script>
