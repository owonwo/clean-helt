<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
	<script src="{{ asset('/js/admin.js') }}"></script>
</head>
<body>
	<main id="admin" class="osq-wrapper">
		<header class="osq-main-navbar">
			<div class="osq-navbar-brand">
				<img src="/images/logo.png" alt=""> CLEAN<b>HELT</b>
			</div>

			<div class="osq-search control has-icons-right">
			    <input class="input" type="text" placeholder="">
			    <span class="icon is-small is-right">
			      <i class="lnr lnr-search"></i>
			    </span>
			</div>

			<nav class="nav-tabs notif-icons">
				<li><a class="nav-link" href="#"> <i class="icon"></i> <span class="count">30</span> </a></li>
				<li><a class="nav-link" href="#"> <i class="icon"></i> <span class="count">1</span> </a></li>
				<li><a class="nav-link" href="#"> <i class="icon"></i> <span class="count">3</span> </a></li>
				<li><a class="nav-link" href="#"> <i class="icon"></i> <span class="count">20</span> </a></li>
				<li><a class="nav-link" href="#"> <i class="icon"></i> <span class="count">0</span> </a></li>
			</nav>

			<div class="avatar-holder">
				<img src="/images/assets/avatar.jpg" alt="" class="avatar">
				<span>Joseph Julius</span>
			</div>
		</header>

		<aside :class="{collapse: sidebars.nav}" class="osq-sidebar">
			<nav>
				<ul>
					<router-link to="/dashboard" tag="li" v-cloak><a href="#"> <i class="icon"></i> Dashboard</a> 
						<span class="toggler" @click="this.toggleSidebar"></span>
					</router-link>
					<router-link to="/users" tag="li" v-cloak><a href="#"> <i class="icon"></i> Users</a> 
						<span class="toggler" @click="this.toggleSidebar"></span>
					</router-link>
{{-- 					<router-link to="" tag="li" v-cloak><a href="#"> <i class="icon"></i> Notification</a></router-link>
					<router-link to="" tag="li" v-cloak><a href="#"> <i class="icon"></i> Settings</a></router-link>
					<router-link to="" tag="li" v-cloak><a href="#"> <i class="icon"></i> Sign Out</a></router-link>
 --}}				</ul>
			</nav>
		</aside>
		<section class="osq-content">
			<section id="content">
				@yield('content')				
			</section>
			
			<aside id="osq-logs" :class="{collapse: sidebars.notif}">
				<router-view name="logBar" id="osq-logs-content">				
				</router-view>
			</aside>
		</section>
	</main>
</body>
</html>
