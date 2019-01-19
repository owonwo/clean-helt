<template>
  <section>
    <section class="content-top-bar">
      <h3>Hospital Profile</h3>
    </section>
    <profile-grid
      ref="grid"
      :name="user.name"
      :avatar-url="edit.avatarUrl"
      :avatar="user.avatar">
      <template slot="navigation">
        <li><a href="#">View Profile</a></li>
        <li><a href="#">View Admin Profile</a></li>
      </template>

      <template slot-scope="pager">
        <pager :current="pager.page">
          <section slot="p1">
            <div 
              class="is-flex" 
              style="justify-content: space-between;">
              <div class="menu-label">Hospital Information</div>
              <save-edit-button 
                :saved="edit.basic" 
                @click="save_basic"/>
            </div>
            <section slot="content">
              <table class="table is-fullwidth is-borderless">
                <tr class="">
                  <th width="150">Name</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.name }}</span>
                    <input 
                      v-else 
                      v-model="user.name" 
                      type="text" 
                      class="input" 
                      placeholder="Name">
                  </td>
                </tr>
                <tr class="">
                  <th>Email</th>
                  <td>	
                    <span v-if="!edit.basic">
                      {{ user.email }}
                    </span>
                    <input 
                      v-else 
                      v-model="user.email" 
                      type="text" 
                      class="input" 
                      placeholder="Email">
                  </td>
                </tr>
                <tr> 
                  <th>Telephone</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.phone }}</span>
                    <input 
                      v-else 
                      v-model="user.phone" 
                      type="text" 
                      class="input" 
                      placeholder="Telephone">
                  </td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.address }}</span>
                    <textarea 
                      v-else 
                      v-model="user.address" 
                      class="textarea" 
                      placeholder="Address"/>
                  </td>
                </tr>
                <tr>
                  <th>State:</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.state }}</span>
                    <select-state
                      v-else 
                      v-model="user.state"
                      class="is-fullwidth"/>
                  </td>
                </tr>
                <tr>
                  <th>City</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.city }}</span>
                    <select-city
                      v-else 
                      v-model="user.city" 
                      class="is-fullwidth"
                      :state="user.state"/>
                  </td>
                </tr>
                <tr>
                  <th>Website</th>
                  <td>
                    <span v-if="!edit.basic">{{ user.website || 'http://' }} <a 
                      :href="user.website" 
                      target="_blank"><i class="ti ti-new-window"/> </a></span>
                    <input 
                      v-else 
                      v-model="user.website" 
                      type="text" 
                      class="input" 
                      placeholder="http://hospital.org">
                  </td>
                </tr>
                <tr>
                  <th>CHCODE</th>
                  <td>
                    {{ user.chcode }} &nbsp;&nbsp;
                    <button 
                      class="button is-round is-small is-primary" 
                      @click="copyTextToClipboard(user.chcode)">COPY
                    </button>
                  </td>
                </tr>
              </table>
            </section>
          </section>

          <section slot="p2">
            <h1 class="menu-label">ADMINISTRATOR INFORMATION</h1>
          </section>
        </pager>
      </template>
    </profile-grid>
  </section>
</template>

<script>
import {mapGetters} from 'vuex'
import ProfileGrid from '@/components/ProfileGrid'
import EditProfile from '@/Mixins/EditProfile.js'

export default {
	name: 'HospitalProfile',
	components: {ProfileGrid},
    mixins: [EditProfile],
	data() {return {
		edit: {
			basic: false,
			url: '/api/hospital/profile',
			avatarUrl: '/api/hospital/avatar',
			whiteList: ['email', 'phone', 'address', 'city', 'state', 'country', 'website'],
		},
	}},
	mounted() {
		document.title = 'Hospital Profile | CleanHelt'
	},
	computed: {
		...mapGetters({user: 'getUser'}),
	},
	methods: {}
}
</script>
