<template>
  <section>
    <div class="level">
      <div>
        <alert 
          v-if="!immunizations.length" 
          class="mb-0"
          type="info">
          You have a clean Immunzation record.
        </alert>
      </div>
      <HoverRevealButton 
        v-if="canEdit"
        @click="(opened = true) && clearForm()">
        <span 
          slot="icon" 
          class="ti ti-plus"/>
        <span slot="text">Add</span>
      </HoverRevealButton>
    </div>

    <table
      v-if="immunizations.length" 
      class="table is-fullwidth">
      <tr>
        <th width="50">S/N</th>
        <th>Immunization</th>
        <th width="50">Age</th>
        <th width="120">Date</th>
        <th  v-if="canEdit" width="50"/>
      </tr>
      <tr 
        v-for="(entry, index) in immunizations" 
        :key="index">
        <td>{{ index + 1 }}</td>
        <td>{{ entry.immunization_title }}</td>
        <td>{{ entry.age }}</td>
        <td>{{ entry.date_of_immunization }}</td>
        <td v-if="canEdit">
          <dropdown>
            <template slot="content"/>
            <template slot="list">
              <li @click="show(entry)">Modify</li>
              <li v-if="isPatient()" @click="trash(entry.id)">Trash</li>
            </template>
          </dropdown>
        </td>
      </tr>
    </table>
    <modal
      ref="modal"
      :show="opened && canEdit"
      @closed="opened = false">
      <CreateImmunization
        :form-data="form"
        @submit="submit"/>
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'
import CreateImmunization from './CreateImmunization.vue'

export default {
  name: 'Immunizations',
  components: { CreateImmunization },
  mixins: [CrudHelper, CanLock],
  data() {return {
    form: {},
    opened: false,
    crud: {
      read: {
        action: 'medicalRecord/FETCH_IMMUNIZATIONS'
      },
      create: {
        action: 'medicalRecord/CREATE_IMMUNIZATION',
        message: { success: 'Immunization added!', error: 'Error adding Immunization' }
      },
      update: {
        action: 'medicalRecord/UPDATE_IMMUNIZATION',
        message: { success: 'Immunization Update Sucessful', error: '' }
      },
      delete: {
        action: 'medicalRecord/DELETE_IMMUNIZATION',
        message: { success: 'Immunization truncated' }
      }
    }
  }},
  computed: {
    ...mapState('medicalRecord', ['immunizations'])
  },
  methods: {
    show(entry) {
      this.form = Object.assign({}, entry)
      this.$refs.modal.toggle()
    },
   validate() {
     return true
   },
 }
}
</script>