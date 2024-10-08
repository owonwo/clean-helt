<template>
  <section>
    <section 
      class="content-top-bar level">
      <h3>Health Services</h3>
    </section>
    
    <section 
      id="health-service-provider" 
      class="card is-rounded is-fullheight">
      <div class="tabs mb-5">
        <ul v-pager-controls>
          <li><a href="#hospital"><i class="osf osf-hospital"/> <span>Hospitals</span></a></li>
          <li><a href="#pharmacy"><i class="osf osf-pharmacy"/> <span>Pharmacies</span></a></li>
          <li><a href="#dianogistics"><i class="osf osf-lab"/> <span>Diagnostic Centres</span></a></li>
        </ul>
        <SearchBox 
          placeholder="Search by Name" 
          v-model="searchString"/>
      </div>
      <span 
        v-preload
        v-if="loading"
        class="is-rounded"/>
      <div v-if="entities.length < 1">
        <blockquote class="notification is-info p-5 mx-15">
          <i>Click the <b>Plus Button</b> (+) to add a Health Service Provider.</i>
        </blockquote>
      </div>
      <pager
        :current="page"
        style="height: 69vh"
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
                <th v-if="shareKey == 'hospitals'" width="50"></th>
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
                <td v-if="shareKey == 'hospitals'">
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
        return name.toLowerCase().includes(search.toLowerCase())
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
