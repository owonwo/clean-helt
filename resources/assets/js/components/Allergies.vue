<template>
  <section>
    <div class="level">
      <div>
        <alert 
          v-if="!allergies.length" 
          class="mb-0" 
          type="info">
          You have a clean Allergy record.
        </alert>
      </div>
      <HoverRevealButton 
        v-if="canEdit"
        @click="opened = true">
        <span 
          slot="icon" 
          class="ti ti-plus"/>
        <span slot="text">Add</span>
      </HoverRevealButton>
    </div>
    <table
      v-if="allergies.length"
      class="table is-fullwidth" 
      style="font-size:small">
      <tr>
        <th width="50">S/N</th>
        <th>Allergy</th>
        <th>Reaction</th>
        <th width="170">Date of Occurence</th>
        <th v-if="canEdit"/>
      </tr>
      <tr 
        v-for="(entry, index) in allergies" 
        :key="index">
        <td>{{ index + 1 }}</td>
        <td>{{ entry.allergy }}</td>
        <td>{{ entry.reaction }}</td>
        <td>{{ entry.last_occurance }}</td>
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
      :show="opened"
      @closed="opened = false">
      <CreateAllergy
        :form-data="form"
        @submit="submit" />
    </modal>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'
import CreateAllergy from './CreateAllergy.vue'

export default {
  name: 'Allergies',
  components: { CreateAllergy },
  mixins: [CrudHelper, CanLock],
  data() {return {
    form: {},
    opened: false,
    crud: {
      read: {
        action: 'medicalRecord/FETCH_ALLERGIES'
      },
      create: {
        action: 'medicalRecord/CREATE_ALLERGY',
        message: { success: 'Allergy added!', error: 'Error adding Allergy' }
      },
      update: {
        action: 'medicalRecord/UPDATE_ALLERGY',
        message: { success: 'Allergy Update Sucessful', error: 'Error Updating Allergy' }
      },
      delete: {
        action: 'medicalRecord/DELETE_ALLERGY',
        message: { success: 'Allergy truncated', error: 'Error Deleting Allergy' }
      }
    }
  }},
  computed: {
    ...mapState('medicalRecord', ['allergies'])
  },
  methods: {
    show(entry) {
      this.form = Object.assign({}, entry)
      this.$refs.modal.toggle()
    }
 }
}
</script>