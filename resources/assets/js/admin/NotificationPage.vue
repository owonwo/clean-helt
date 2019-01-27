<template>
  <section>
    <div class="content-top-bar">
      <h3>
        <i class="icon osf osf-notification"/>
        <span>Notifications</span>
      </h3>
    </div>
    <section class="card is-rounded mb-5">
      <v-scrollbar 
        style="max-width: 100%" 
        class="tabs">
        <ul class="py-10">
          <li 
            :class="{'is-active': current == 0}" 
            @click="current=0"><a href="#">General</a></li>
          <li 
            :class="{'is-active': current == 1}" 
            @click="current=1"><a href="#">Patients</a></li>
          <li 
            :class="{'is-active': current == 2}" 
            @click="current=2"><a href="#">Hospital</a></li>
          <li 
            :class="{'is-active': current == 3}" 
            @click="current=3"><a href="#">Pharmacy</a></li>
          <li 
            :class="{'is-active': current == 4}" 
            @click="current=4"><a href="#">Doctors</a></li>
        </ul>
      </v-scrollbar>

      <pager 
        :current="current" 
        style="height: 70vh"
        align="top">
        <div 
          v-for="ai in 6" 
          :slot="'p'+ai" 
          :key="ai">
          <h5>Today {{ ai }}</h5>
          <ul class="notifications">
            <notification-card 
              v-for="a in 3" 
              :key="'1'+a" 
              type="primary">
              Account Creation was successful.
            </notification-card>				
          </ul>
          <h5>Yesterday</h5>
          <ul class="notifications">
            <notification-card 
              v-for="a in 7" 
              :key="'2'+a" 
              account="doctor" 
              type="warning">
              Patients reported a pharmacy.
            </notification-card>
          </ul>
          <h5>2 days</h5>
          <ul class="notifications">
	          <notification-card 
	            v-for="a in 3" 
	            :key="'3'+a" 
	            account="doctor" 
	            type="danger">
	            An Admin was delete by the Super Admin..
	          </notification-card>
          </ul>
        </div>
      </pager>
    </section>
  </section>
</template>

<style scoped>
	.notifications {
		position: relative;
	}
</style>

<script>
import NotificationCard from '@/components/NotificationCard.vue'

export default {
	components: {NotificationCard},
	data() {return {
		current: 0,
	}}
}
</script>
