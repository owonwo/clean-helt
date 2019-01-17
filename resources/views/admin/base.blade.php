<!DOCTYPE html>
<html>

<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css', true) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.min.css">
    
    <script src="{{ asset('/js/admin.js', true) }}"></script>
    <style>
    	[v-cloak] { display: none;}
    </style>
</head>

<body>
    <main id="admin" v-cloak class="osq-wrapper">
        <header class="osq-main-navbar">
            <div class="osq-navbar-brand">
                CH<b>ADMIN</b>
            </div>
            <section class="level my-0">
                <div class="osq-search-field control has-icons-right">
                    <input class="input" type="text" placeholder="Search">
                    <span class="icon osf osf-search is-small is-right"></span>
                </div>
                <nav class="nav-tabs ml-15 notif-icons">
                    <li><a class="nav-link" href="#"> 
                        <i class="osf osf-client-alt-green"></i>
                         <span class="count"> @{{ counts.patients }}</span> </a>
                    </li>
                    <li><a class="nav-link" href="#"> 
                        <i class="osf osf-doctor-green"></i> 
                        <span class="count"> @{{ counts.doctors }}</span> </a>
                    </li>
                    <li><a class="nav-link" href="#"> 
                        <i class="osf osf-pharmacy-green"></i> 
                        <span class="count"> @{{ counts.pharmacies }}</span> </a>
                    </li>
                    <li><a class="nav-link" href="#"> 
                        <i class="osf osf-lab-green"></i> 
                        <span class="count"> @{{ counts.labs }}</span> </a>
                    </li>
                    <li><a class="nav-link" href="#"> 
                        <i class="osf osf-hospital-green"></i> 
                        <span class="count"> @{{ counts.hospitals }}</span> </a>
                    </li>
                </nav>
            </section>
            <div class="avatar-holder">
                <img src="/images/assets/avatar.jpg" alt="" class="avatar">
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>
        <aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
            <nav>
                <ul>
                    <custom-link to="/dashboard" icon="osf osf-dashboard-white" name="Dashboard">
                    </custom-link>
                    <custom-link to="/users" icon="osf osf-users-white" name="Users">
                    </custom-link>
                    <custom-link to="/notifications" icon="osf osf-notification-white" name="Notifications">
                    </custom-link>
                    <custom-link to="/create-provider" icon="osf osf-add-white" name="Create Provider">
                    </custom-link>
                    @if (auth()->user()->roles == "Super Admin")
                        <custom-link to="/manage-admins" icon="osf osf-user-white" name="Administrators">
                        </custom-link>
                    @endif
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
                <router-view/>
            </section>
            <aside id="osq-logs" :class="{collapse: $root.sidebars.notif}">
                <router-view id="osq-logs-content" name="logBar" />
            </aside>
        </section>
        <notifications :position="['bottom', 'right']"></notifications>
    </main>
</body>
</html>
