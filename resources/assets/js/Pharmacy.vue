<template>
  <main id="doctor" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
      </div>

      <div class="avatar-holder">
        <img :src="$root.avatar" alt="" class="avatar">
        <span>{{ user.name }}</span>
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <custom-link to="/dashboard" icon="osf osf-dashboard" name="Dashboard"/>
          <custom-link to="/patients" icon="osf osf-patient-white" name="Clients"/>
          <custom-link to="/notifications" icon="osf osf-bell" name="Notifications"/>
          <custom-link to="/profile" icon="osf osf-pharmacy-white" name="Profile"/>
        </ul>
      </nav>
      <footer>
        <ul class="">
          <li><a @click="logout" href="#"><i class="osf osf-signout"></i> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-comment"></i> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <keep-alive :exclude="['Patients','Profile']">
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
  name: 'Pharmacy',
  mixins: [LoggedIn],
  router: routes.pharmacy,
  data() {return {
      settings : {
        profile: { route: `/api/pharmacy/profile`, key: 'pharmacy' },
        patients: { route : `/api/pharmacy/patients`, key: 'patients'}
      },
  }},
  methods: {
    /**
     * String chcode - patients chcode 
     * String reference - prescription to reference medical record 
     * Integer pre_id - the prescription id 
     * @returns 
    */
    async markAsDispensed(chcode, reference, pre_id) {
      if(!this.testChCode(chcode)) 
        return console.log('invalid chcode provided for markAsDispensed function');
      const url = `/api/pharmacy/patients/${chcode}/prescriptions/${reference}/${pre_id}`;
      return this.$http.patch(url);
    }
  }
}
</script>
