<template>
	<main id="doctor" v-cloak class="osq-wrapper">
		<header class="osq-main-navbar">
			<div class="osq-navbar-brand">
				<img style="height: 25px" src="@/../assets/logo-full@4.png" alt="">
			</div>

			<div class="avatar-holder">
				<img :src="user.avatar" alt="" class="avatar">
				<span>{{ user.full_name }}</span>
			</div>
		</header>

		<aside :class="{collapse: $root.sidebars.nav}" class="osq-sidebar">
			<nav>
				<ul>
					<router-link to="/dashboard" tag="li">
						<a href="#">
							<i class="osf osf-dashboard-white"></i> Dashboard</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/services" tag="li">
						<a href="#">
							<i class="osf osf-department-white"></i> Health Services</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/profile" tag="li">
						<a href="#">
							<i class="osf osf-client-alt-white"></i> Profile</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/Notifications" tag="li">
						<a href="#">
							<i class="osf osf-notification-white"></i> Notifications</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>

					<router-link to="/settings" tag="li">
						<a href="#">
							<i class="osf osf-settings-white"></i> Settings</a>
						<span class="toggler" @click="$root.toggleSidebar"></span>
					</router-link>
				</ul>
			</nav>
			<footer>
				<ul class="">
					<li>
						<a @click.prevent="logout">
							<i class="osf osf-back-alt-white"></i> Sign Out</a>
					</li>
					<li>
						<a href="#">
							<i class="osf osf-forum-white"></i> Log into Forum</a>
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
		return Object.assign({visible: true}, share, overwrites);
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
						key: 'data'
					},
					patients: {
						route: '/api/patient',
						key: 'data'
					}
				},
				shares: [],
				recordUrlMap: Object.freeze({
					labtest:"/api/patient/labtest",
					prescription: "/api/patient/prescription",
					medicalRecord: "/api/patient/medical-records",
				}),
			}
		},
		methods: {
			async getRecord(record_type) {
				const {recordUrlMap} = this;
				if(!Object.keys(recordUrlMap).includes(record_type))
					(new Error('Invalid Patient Record Name provided'));
				return await this.$http.get(recordUrlMap[record_type].replace('{patient}', this.$props.id || 'invalid'));
			},
			fetchProfileShares() {
				return new Promise((resolve, rej) => {
					this.$http.get('/api/patient/profile/shares').then((res) => {
						this.shares = res.data.shares.map(shareFactory);
						resolve(this.shares);
					}).catch((err) => {
						console.log('An Error Occured. Trying to fetch Patient Shares!', err);
						rej(err);
					})
				});
			}
		}
	}
</script>
