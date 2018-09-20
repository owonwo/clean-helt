<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
    <script src="{{ asset('/js/admin.js') }}"></script>
    <style>
    	[v-cloak] { display: none;}
    </style>
</head>

<body>
    <main id="admin" v-cloak class="osq-wrapper">
        <header class="osq-main-navbar">
            <div class="osq-navbar-brand">
                <img src="/images/logo.png" alt=""> CH<b>ADMIN</b>
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
                    <custom-link to="/dashboard" icon="osf osf-dashboard" name="Dashboard">
                    </custom-link>
                    <custom-link to="/users" icon="osf osf-users" name="Users">
                    </custom-link>
                    <custom-link to="/notifications" icon="osf osf-bell" name="Notifications">
                    </custom-link>
                    <custom-link to="/create-provider" icon="osf osf-patient" name="Create Provider">
                    </custom-link>
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
                <router-view id="osq-logs-content" name="logBar" />
            </aside>
        </section>
    </main>
</body>

</html>
