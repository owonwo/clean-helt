<template>
  <section>
    <HoverRevealButton @click="opened = true">
      <span 
        slot="icon" 
        class="ti ti-plus"/>
      <span slot="text">Add</span>
    </HoverRevealButton>
    <alert 
      v-if="!allergies.length" 
      type="info">
      You have a clean Allergy record.
    </alert>
    <table 
      v-else 
      class="table is-fullwidth" 
      style="font-size:small">
      <tr>
        <th width="50">S/N</th>
        <th>Allergy</th>
        <th>Reaction</th>
        <th width="170">Date of Occurence</th>
        <th/>
      </tr>
      <tr 
        v-for="(entry, index) in allergies" 
        :key="index">
        <td>{{ index + 1 }}</td>
        <td>{{ entry.allergy }}</td>
        <td>{{ entry.reaction }}</td>
        <td>{{ entry.last_occurance }}</td>
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
      <CreateAllergy 
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
import CreateAllergy from './CreateAllergy.vue'

export default {
	name: 'Allergies',
	components: { CreateAllergy },
    mixins: [CrudHelper],
	data() {return {
		form: {},
		opened: false,
		crud: {
            read: {
                action: 'medicalHistory/FETCH_ALLERGIES'
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
        ...mapState('medicalHistory', ['allergies'])
    },
    methods: {
		show(entry) {
				this.form = Object.assign({}, entry)
				this.opened = true
		},
        saveContact() {
            // if (contact.isEditing) this.update(contact)
            // contact.toggleEdit()
        },
        error() {
        	this.error_message('Error updating')
        	this.opened = false
        },
        success() {
        	this.success_message('Allergy Updated')
        	this.opened = false
        	this.form = {}
        	this.$store.dispatch(this.crud.read.action)
        },
        validate() {
			return false
            // return Object.keys(this.form).length === 5
        },
    }
}
</script>