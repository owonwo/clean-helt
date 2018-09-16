<template>
	<main id="doctor" v-cloak class="osq-wrapper">
		<header class="osq-main-navbar">
			<div class="osq-navbar-brand">
				<img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
			</div>

			<div class="avatar-holder">
				<img :src="$root.avatar" alt="" class="avatar">
				<span>{{ user.full_name }}</span>
			</div>
		</header>

		<aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
			<nav>
				<ul>
					<router-link to="/dashboard" tag="li">
						<a href="#">
							<i class="osf osf-dashboard"></i> Dashboard</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/services" tag="li">
						<a href="#">
							<i class="osf osf-department"></i> Health Services</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/profile" tag="li">
						<a href="#">
							<i class="osf osf-patient-white"></i> Profile</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/Notifications" tag="li">
						<a href="#">
							<i class="osf osf-bell"></i> Notifications</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/settings" tag="li">
						<a href="#">
							<i class="osf osf-settings"></i> Settings</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>
				</ul>
			</nav>
			<footer>
				<ul class="">
					<li>
						<a href="#">
							<i class="osf osf-signout"></i> Sign Out</a>
					</li>
					<li>
						<a href="#">
							<i class="osf osf-comment"></i> Log into Forum</a>
					</li>
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
</template>

<script>
	import routes from './routes';
	import LoggedIn from '@/Mixins/LoggedIn';

	const shareFactory = (share)  => {
		const pickName = () => {
			let {first_name, last_name, name} = share.provider
			return share.provider_type === 'App\\Models\\Doctor' 
				? `Dr ${first_name} ${last_name}` : name; 
		}
		const  overwrites = {
			provider_type: share.provider_type.replace('App\\Models\\', ""),
			status: Number(share.status),
			provider: Object.assign(share.provider, { name: pickName() }),
		}
		return Object.assign(share, overwrites);
	}

	export default {
		name: 'Patient',
		mixins: [LoggedIn],
		router: routes.patient,
		data() {
			return {
				settings: {
					profile: {
						route: `/api/patient/profile`,
						key: 'patient'
					},
					patients: {
						route: '/api/patient',
						key: 'patients'
					}
				},
				shares: []
			}
		},
		methods: {
			async getRecord(record_type) {
				const recordUrlMap = Object.freeze({
					labtest:"/api/patient/{patient}/labtest",
					prescription: "/api/patient/{patient}/prescription",
					medicalRecord: "/api/patient/{patient}/medical-records",
				});
				if(!Object.keys(recordUrlMap).includes(record_type))
					(new Error('Invalid Patient Record Name provided'));
				return await this.$http.get(recordUrlMap[record_type]);
			},
			fetchProfileShares() {
				this.$http.get('/api/patient/profile/shares').then((res) => {
					this.shares = res.data.shares.map(shareFactory);
				}).catch((err) => {
					console.log('An Error Occured. Trying to fetch Patient Shares!', err);
				})
			}
		}
	}
</script>