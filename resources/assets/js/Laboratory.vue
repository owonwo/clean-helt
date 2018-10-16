<template>
  <main id="doctor" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
      </div>

      <div class="avatar-holder">
        <img :src="user.avatar" alt="" class="avatar">
        <span>{{ user.name }}</span>
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <custom-link to="/dashboard" icon="osf osf-dashboard-white" name="Dashboard" />
          <custom-link to="/patients" icon="osf osf-client-alt-white" name="Clients" />
          <custom-link to="/profile" icon="osf osf-client-alt-white" name="Profile" />
          <custom-link to="/Notifications" icon="osf osf-notification-white" name="Notifications" />
        </ul>
      </nav>

      <footer>
        <ul class="">
          <li><a href="#" @click="logout()"><i class="osf osf-back-alt-white"></i> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-forum-white"></i> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <keep-alive exclude="['Profile']">
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
  name: 'Laboratory',
  mixins: [LoggedIn],
  router: routes.lab,
  data() {return {
      settings : {
        profile: { route: `/api/laboratory/profile`, key: 'laboratory' },
        patients: { route : '/api/laboratory/patients', key: 'patients'}
      },
  }}
}
</script>
