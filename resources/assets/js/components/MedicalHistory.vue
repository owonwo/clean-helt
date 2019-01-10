<template>
  <section>
    <div class="level">
      <div>
        <alert 
          v-if="!histories.length" 
          class="mb-0" 
          type="info">
          You have a clean Medical History.
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
      v-if="histories.length" 
      class="table is-fullwidth">
      <tr>
        <th width="10">S/N</th>
        <th>Illness</th>
        <th>Date of Onset</th>
        <th>Actions</th>
      </tr>
      <tr 
        v-for="(entry, index) in histories" 
        :key="index">
        <td v-text="index + 1" />
        <td v-text="entry.illness" />
        <td v-text="entry.date_of_onset" />
        <td class="level level-right">
          <dropdown>
            <template slot="content"/>
            <template slot="list">
              <li @click="show(entry)">Modify</li>
              <li @click="trash(entry.id)">Trash</li>
            </template>
          </dropdown>
        </td>
      </tr>
    </table>
    <modal 
      ref="modal" 
      :show-header="true" 
      :show="opened && canEdit" 
      @closed="opened = false">
      <span slot="modal-title">Add Medical History</span>
      <form @submit.prevent="submit(form)">
        <wgInput 
          v-model="form.illness" 
          type="text" 
          label="Illness" 
          placeholder="Illness" />
        <wgInput 
          v-model="form.date_of_onset" 
          label="Date of Onset" 
          type="date" />
        <wgInput 
          v-model="form.description" 
          label="Illness Description" 
          type="textarea" 
          placeholder="Write something about the Illness" />
        <div class="field">
          <button 
            v-if="!!form.id" 
            class="button is-primary">Update</button>
          <button 
            v-else 
            class="button is-primary">Create</button>
        </div>
      </form>
    </modal>
  </section>
</template>
<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'

export default {
  name: 'MedicalHistory',
    // components: { CreateImmunization },
    mixins: [CrudHelper, CanLock],
    data() {
      return {
        index: false,
        opened: false,
        form: {
          illness: '',
          description: '',
          date_of_onset: '',
        },
        crud: {
          read: {
            action: 'medicalRecord/FETCH_MEDICAL_HISTORY'
          },
          create: {
            action: 'medicalRecord/CREATE_MEDICAL_HISTORY',
            message: { success: 'Medical History added!', error: 'Error adding Medical History' }
          },
          update: {
            action: 'medicalRecord/UPDATE_MEDICAL_HISTORY',
            message: { success: 'Medical History Updated Sucessfully', error: '' }
          },
          delete: {
            action: 'medicalRecord/DELETE_MEDICAL_HISTORY',
            message: { success: 'Medical History truncated' }
          }
        }
      }
    },
    computed: {
      ...mapState('medicalRecord', {
        histories: (store) => store.histories
      })
    },
    mounted() {
      this.$store.dispatch('medicalRecord/FETCH_MEDICAL_HISTORY')
    },
    methods: {
      show(entry) {
        this.form = Object.assign({}, entry)
        this.$refs.modal.toggle()
      }
    },
  }
  </script>