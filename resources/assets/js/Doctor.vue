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
          <custom-link to="/dashboard" icon="osf osf-dashboard-white" name="Dashboard"/>
          <custom-link to="/patients" icon="osf osf-client-alt-white" name="Clients"/>
          <custom-link to="/profile" icon="osf osf-doctor-white" name="Profile"/>
        </ul>
      </nav>
      <footer>
        <ul class="is-small">
          <li><a @click.prevent="logout"><i class="osf osf-back-alt-white"></i> Sign Out</a></li>
          <li><a href="#"><i class="osf osf-forum-white"></i> Log into Forum</a></li>
        </ul>
      </footer>
    </aside>

    <section class="osq-content">
      <section id="content">
        <keep-alive :exclude="['Patients']">
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
import routes from './routes'
import LoggedIn from '@/Mixins/LoggedIn'

export default {
    name: 'Doctor',
    props: ['id'],
    router: routes.doctor,
    mixins: [LoggedIn], // comes with all mutations and getters
    created() {
      this.fetchHospitals();
      axios.get('/api/doctor/notifications').then((res) => {
        res.data;
      })
    },
    data() {return {
      settings : {
        profile: { route: `/api/doctor/profile`, key: 'doctor' },
        patients: { route : '/api/doctor/patients', key: 'patients'}
      },
      pendingHospital: [],
      sentHospital: [],
      hospitals: [],
    }},
    methods: {
      async getHospital() {
        return await axios.get('/api/doctor/active-hospitals')
      },
      manageHospital(hospital, type = "") {
        const actions = {
          accept: `/api/doctor/${hospital.chcode}/accept-hospital`,
          decline: `/api/doctor/${hospital.chcode}/decline-hospital`,
          remove: `/api/doctor/${hospital.chcode}/remove-hospital`,
        }
        this.$http.patch(actions[type]).then(() => {
          this.fetchHospitals();
        });
      },
      fetchHospitals() {
        this.getHospital().then((res) => {
          this.hospitals = res.data.hospitals;
        });
        this.$http.get('/api/doctor/sent-hospitals').then((res) => {
          this.sentHospital = res.data.hospitals;
        });
        this.$http.get('/api/doctor/pending-hospitals').then((res) => {
          this.pendingHospital = res.data.hospitals;
        });
      }
    }
}
</script>
