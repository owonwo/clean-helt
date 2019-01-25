<template>
  <section>
    <section>
      <!-- create contacts form -->
      <div 
        v-if="canEdit"
        class="level">
        <div>
          <alert 
            v-if="contacts.length < 1" 
            type="info">No Emergency Contacts</alert>
        </div>
        <HoverIconButton
          :active="opened"
          :icons="['ti-plus:Add', 'ti-minus:Close']"
          @click="opened = !opened"/>
      </div>
      <!-- create form -->
      <form 
        v-if="opened" 
        @submit.prevent="create">
        <div class="field-body field">
          <div class="field">
            <input 
              v-model="form.name" 
              type="text" 
              class="input"
              tabindex="1" 
              placeholder="Contact Full Name">
          </div>
          <div class="field">
            <input 
              v-model="form.zip_code" 
              type="number" 
              class="input"
              tabindex="1" 
              placeholder="zip_code">
          </div>
        </div>
        <div class="field-body field">
          <div class="field">
            <input 
              v-model="form.phone" 
              type="text" 
              class="input" 
              tabindex="2" 
              placeholder="Phone Number">       
          </div>
          <div class="field">
            <input 
              v-model="form.phone_2" 
              type="text"
              class="input" 
              tabindex="2" 
              placeholder="Phone Number 2">       
          </div>
        </div>
        <div class="field-body field">
          <div class="field">
            <textarea
              v-model="form.address"
              placeholder="Location/Address" 
              tabindex="4"
              class="textarea"/>
          </div>
        </div>
        <div class="field">     
          <button 
            class="button is-primary" 
            tabindex="5">Add to Contact</button>
        </div>
      </form>
      <!-- contacts list -->
      <div
        v-for="(contact, index) in contacts"
        :key="index"
        class="card is-hospital m-5">
        <div class="card-content">
          <template v-if="contact.isEditing">
            <div 
              v-if="contact.isEditing"
              class="field">
              <div class="field">
                <div class="control">
                  <input
                    v-model="contact.name"
                    class="input"
                    placeholder="Contact Full Name"
                    type="text">
                </div>
              </div>
              <div class="field-body">
                <div class="field">
                  <input 
                    v-if="contact.isEditing" 
                    v-model="contact.phone" 
                    class="h--input"
                    placeholder="Phone Number" 
                    type="text">
                </div>
                <div class="field">
                  <input 
                    v-if="contact.isEditing" 
                    v-model="contact.phone_2" 
                    class="h--input"
                    placeholder="Phone Number 2" 
                    type="text">
                </div>
              </div>
              <div
                class="field-body">
                <div class="field">
                  <input 
                    v-model="contact.address"
                    placeholder="Address" 
                    class="h--input" 
                    type="text">
                </div>
                <div class="field">
                  <input 
                    v-model="contact.zip_code" 
                    class="h--input"
                    placeholder="Zip Code" 
                    type="text">
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <h3 class="title is-5 mt-0">
              {{ (index + 1) + '. ' + contact.name }}
            </h3>
            <p>
              <i class="ti ti-mobile mr-10"/>
              <span class="osq-text-green">{{ contact.phone }}</span>
              <span class="osq-text-green ml-10">{{ contact.phone_2 }}</span>
            </p>
            <p>
              <i class="ti ti-home mr-10"/>
              <span> {{ contact.address }} - <i>{{ contact.zip_code }}</i> </span>
            </p>
          </template>
          <div 
            v-if="canEdit" 
            class="buttons is-right">
            <save-edit-button
              :saved="contact.isEditing"
              class="mr-5"
              @click="saveContact(contact)"/> 
            <button 
              class="button is-small is-outlined" 
              @click="trash(contact.id)">
              <i class="ti ti-trash"/> Delete
            </button>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>
<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'

export default {
  name: 'EmergencyContacts',
  mixins: [CrudHelper, CanLock],
  data() {
    return {
      form: {
      },
      opened: false,
      index: false,
      crud: {
        read: {
          action: 'patient_share/FETCH_CONTACTS'
        },
        create: {
          action: 'patient_share/CREATE_CONTACT',
          message: { success: 'Contact contact added!', error: 'Error adding Contact' }
        },
        update: {
          action: 'patient_share/UPDATE_CONTACT',
          message: { success: 'Contact Update Sucessful', error: '' }
        },
        delete: {
          action: 'patient_share/DELETE_CONTACT',
          message: { success: 'Contact truncated' }
        }
      }
    }
  },
  computed: {
    ...mapState('patient_share', ['contacts'])
  },
  methods: {
    saveContact(contact) {
      if (contact.isEditing) {
        this.set_form(Object.assign({}, contact)).update()
      }
        contact.toggleEdit()
    },
    validate() {
      return Object.keys(this.form).length === 5
    },
  }
}
</script>