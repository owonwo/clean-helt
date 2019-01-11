<template>
  <section>
    <section 
      class="content-top-bar level">
      <h3>Health Services</h3>
    </section>
    
    <section class="card is-fullheight">
      <div class="tabs mb-5">
        <ul v-pager-controls>
          <li><a href="#" >Hospitals</a></li>
          <li><a href="#">Pharmacies</a></li>
          <li><a href="#">Diagnostic Centres</a></li>
        </ul>
        <ul class="is-right">
          <li>
            <SearchBox 
              placeholder="Search by Name" 
              @value="e => searchString = e.toLowerCase()"/>
          </li>
        </ul>
      </div>
      <span
        v-preload
        v-if="loading"
        class="block is-rounded mx-15"/>
      <div v-if="entities.length < 1">
        <blockquote class="notification is-info p-5 mx-15">
          <i>Click the <b>Plus Button</b> (+) to add a Health Service Provider.</i>
        </blockquote>
      </div>
      <section class="card-body">
        <pager
          :current="page"
          class="is-absolute" 
          align="top">
          <div
            v-for="(shareKey, index) in serviceProviderOrder" 
            :slot="'p'+(index+1)"
            :key="index">
            <table class="table is-hoverable is-fullwidth">
              <thead>
                <tr>
                  <th>Name</th>
                  <th width="100">CHCODE</th>
                  <th width="">Contact</th>
                  <th width="">Location</th>
                  <th width="50"></th>
                </tr>
              </thead>
              <tbody>
                <tr 
                  v-for="(share, index) in filtered" 
                  :key="index">
                  <td><a @click.prevent="modal = true">{{ share.name || [share.first_name, share.last_name].join(' ') || 'Unknown' }}</a></td>
                  <td class="has-text-grey-darker">{{ share.chcode }}</td>
                  <td>{{ share.phone }}</td>
                  <td>{{ [share.city, share.state].join(' - ') }}</td>
                  <td>
                    <router-link
                      :to="{name: 'profile-share', params: {chcode: share.chcode}}"
                      tag="button"
                      class="button is-small is-primary is-block">
                      <i class="icon ti ti-share"/> <span>Share</span>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </pager>
        <div class="px-5">
          <alert 
            v-if="!!searchString && filtered.length === 0" 
            type="info"
            class="is-italic">
            <span 
              class="tag" 
              v-text="searchString"/> not available.
          </alert>
        </div>
      </section>
    </section>

    <modal :show="false">
      <h1>Diagnostics Centre</h1>
      <h3>Johnson Parker Mobby</h3>
      <ul class="menu">
        <li class="menu-label">Services</li>
        <li 
          v-for="(service, index) in current.services" 
          :key="index"
          class="menu-list">{{ service }}
        </li>
      </ul>
    </modal>
  </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Pager from '@/components/Pager.vue'
import Modal from '@/components/Modal.vue'

export default {
  name: 'ServiceProviders',
  components: {Pager, Modal},
  data() {return {
    page: 0,
    modal: false,
    current: {
      services: []
    },
    searchString: '',
    serviceProviderOrder: ['hospitals','pharmacies','laboratories']
  }},
  computed: {
    currentPage() { return this.serviceProviderOrder[this.page] },
    filtered () {
      const {searchString: search, currentPage, entities} = this
      return entities[currentPage].filter((e) => {
        const name = e.name || [e.first_name, e.last_name].join(' ') || ''
        return !search || name.toLowerCase().includes(search)
      })
    },
    ...mapGetters('service_providers', ['loading']),
    ...mapState('service_providers', ['entities'])
  },
  mounted() {
    this.loadEntities()
  },
  methods: {
    loadEntities() {
      this.$store.dispatch('service_providers/FETCH')
    },
  }
}
</script>
