<template>
  <section>
    <HoverRevealButton @click="opened = true">
      <span 
        slot="icon" 
        class="ti ti-plus"/>
      <span slot="text">Add</span>
    </HoverRevealButton>
    <alert 
      v-if="!immunizations.length" 
      type="info">
      You have a clean Immunzation record.
    </alert>
    <table 
      v-else 
      class="table is-fullwidth">
      <tr>
        <th width="50">S/N</th>
        <th>Title</th>
        <th width="50">Age</th>
        <th width="120">Date</th>
        <th width="50"/>
      </tr>
      <tr 
        v-for="(entry, index) in immunizations" 
        :key="index">
        <td>{{ index + 1 }}</td>
        <td>{{ entry.immunization_title }}</td>
        <td>{{ entry.age }}</td>
        <td>{{ entry.date_of_immunization }}</td>
        <td>
          <dropdown>
            <template slot="content"/>
            <template slot="list">
              <li @click="show(entry)">Modify</li>
              <li>Trash</li>
            </template>
          </dropdown>
        </td>
      </tr>
    </table>
    <modal 
      :show="opened"
      @closed="opened = false">
      <CreateImmunization 
        v-if="opened" 
        :form-data="form"
        @success="success" 
        @error="error" />
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CrudHelper from '@/Mixins/CrudHelper'
import CreateImmunization from './CreateImmunization.vue'

export default {
  name: 'Immunizations',
  components: { CreateImmunization },
  mixins: [CrudHelper],
  data() {return {
    form: {},
    opened: false,
    crud: {
      read: {
        action: 'medicalHistory/FETCH_IMMUNIZATIONS'
      },
      create: {
        action: 'medicalHistory/CREATE_CONTACT',
        message: { success: 'Contact contact added!', error: 'Error adding Contact' }
      },
      update: {
        action: 'medicalHistory/UPDATE_CONTACT',
        message: { success: 'Contact Update Sucessful', error: '' }
      },
      delete: {
        action: 'medicalHistory/DELETE_CONTACT',
        message: { success: 'Contact truncated' }
      }
    }
  }},
  computed: {
    ...mapState('medicalHistory', ['immunizations'])
  },
  methods: {
    show(entry) {
      this.form = Object.assign({}, entry)
      this.opened = true
    },
    error() {
     this.error_message('Error updating Immunization')
     this.opened = false
   },
   success() {
    this.success_message('Immunization Updated')
     this.opened = false
     this.form = {}
     this.$store.dispatch(this.crud.read.action)
   },
   validate() {
     return false
   },
 }
}
</script>