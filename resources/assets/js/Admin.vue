<template>
  <main id="admin" v-cloak class="osq-wrapper">
    <header class="osq-main-navbar">
      <div class="osq-navbar-brand">
        <img src="/images/logo.png" alt=""> CLEAN<b>HELT</b>
      </div>

      <section class="level my-0">
        <div class="osq-search-field control has-icons-right">
            <input class="input" type="text" placeholder="Search">
            <span class="icon osf osf-search is-small is-right">
            </span>
        </div>

        <nav class="nav-tabs ml-15 notif-icons">
          <li><a class="nav-link" href="#"> <i class="osf osf-patient"></i> <span class="count">30</span> </a></li>
          <li><a class="nav-link" href="#"> <i class="osf osf-doctor"></i> <span class="count">1</span> </a></li>
          <li><a class="nav-link" href="#"> <i class="osf osf-pharmacy"></i> <span class="count">3</span> </a></li>
          <li><a class="nav-link" href="#"> <i class="osf osf-lab"></i> <span class="count">20</span> </a></li>
          <li><a class="nav-link" href="#"> <i class="osf osf-hospital"></i> <span class="count">0</span> </a></li>
        </nav>
      </section>

      <div class="avatar-holder">
        <img src="assets/logo.png" alt="" class="avatar">
        <span>Joseph Julius</span>
      </div>
    </header>

    <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
      <nav>
        <ul>
          <router-link to="/dashboard" tag="li">
            <a href="#"><i class="osf"></i> Dashboard</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
          <router-link to="/users" tag="li">
            <a href="#"> <i class="osf osf-users"></i> Users</a> 
            <span class="toggler" @click="$root.toggleSidebar"></span>
          </router-link>
          <router-link to="/notifications" tag="li">
            <a href="#"> <i class="osf osf-bell"></i> Notifications</a> 
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
export default {
  name: 'App',
  router: routes.admin
}
</script>
