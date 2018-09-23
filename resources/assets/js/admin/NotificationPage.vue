<template>
	<section class="card">
		<div class="card-header">
			<span class="card-header-icon"><i class="icon osf osf-notification"></i></span>
			<span class="card-header-title">Notification</span>
		</div>
		<div class="tabs">
			<ul>
				<li  @click="current=0" :class="{'is-active': current == 0}"><a href="#">General</a></li>
				<li  @click="current=1" :class="{'is-active': current == 1}"><a href="#">Patients</a></li>
				<li  @click="current=2" :class="{'is-active': current == 2}"><a href="#">Hospital</a></li>
				<li  @click="current=3" :class="{'is-active': current == 3}"><a href="#">Pharmacy</a></li>
				<li  @click="current=4" :class="{'is-active': current == 4}"><a href="#">Doctors</a></li>
			</ul>
		</div>
		<pager align="top" :current="current">
			<div class="card-content" :slot="'p'+ai" :key="ai" v-for="ai in 6">
				<h5>Today {{ ai }}</h5>
				<ul class="notifications is-flat">
					<notification-card type="primary" :key="'1'+a" v-for="a in 3">
						Account Creation was successful.
					</notification-card>				
				</ul>
				<h5>Yesterday</h5>
				<ul class="notifications is-flat">
					<notification-card account="doctor" type="warning" :key="'2'+a" v-for="a in 7">
						Patients reported a pharmacy.
					</notification-card>
				</ul>
				<h5>2 days</h5>
				<notification-card account="doctor" type="danger" :key="'3'+a" v-for="a in 3">
					An Admin was delete by the Super Admin..
				</notification-card>
			</div>
		</pager>
	</section>
</template>

<style scoped>
	.notifications {
		position: relative;
	}
</style>

<script>
import NotificationCard from '@/components/NotificationCard.vue';

export default {
	components: {NotificationCard},
	data() {return {
		current: 0,
	}}
}
</script>
