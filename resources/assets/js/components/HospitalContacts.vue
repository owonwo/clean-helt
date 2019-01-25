<template>
  <section class="cont">
    <!-- create contacts form -->
    <div 
      v-if="canEdit"
      class="level">
      <div>
        <alert 
          v-if="contacts.length < 1" 
          type="info">
          No Hospital Contacts
        </alert>
      </div>
      <HoverIconButton 
        :active="opened"
        :icons="['ti-plus:Add', 'ti-minus:Close']"
        @click="opened = !opened"/>
    </div>
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
            placeholder="Hospital Name">
        </div>
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
            v-model="form.email" 
            type="email" 
            class="input" 
            tabindex="3" 
            placeholder="Email">        
        </div>
        <div class="field">     
          <button 
            class="button is-primary" 
            tabindex="5">Create</button>
        </div>
      </div>
      <div class="field-body field">
        <div class="field">
          <textarea
            v-model="form.location"
            placeholder="Location/Address" 
            tabindex="4"
            class="textarea"/>
        </div>
      </div>
    </form>
    <!-- contacts list -->
    <div
      v-for="(contact, index) in contacts"
      :key="index"
      class="card is-rounded m-5">
      <div class="card-content">
        <form 
          v-if="contact.isEditing">
          <wgInput
            v-model="contact.name"
            placeholder="Hospital Name"
            type="text"/>
          <div class="field">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.email" 
              class="h--input" 
              placeholder="Email Address" 
              type="email">
          </div>
          <div class="field">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.phone" 
              class="h--input"
              placeholder="Telephone" 
              type="text">
          </div>
          <div class="field">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.location" 
              class="h--input" 
              placeholder="Location" 
              type="text">
          </div>
        </form>
        <template v-else> 
          <h3 class="title is-5 mt-0">
            <span 
              v-text="contact.name"/>
          </h3>
          <p>
            <i class="ti ti-email mr-10"/>
            <span 
              class="osq-text-green">{{ contact.email }}</span>
          </p>
          <p>
            <i class="ti ti-mobile mr-10"/>
            <span 
              class="osq-text-green">{{ contact.phone }}</span>
          </p>
          <p>
            <i class="ti ti-home mr-10"/>
            <span> {{ contact.location }} </span>
          </p>
        </template>
        <div 
          v-if="canEdit" 
          class="my-5 buttons is-right">
          <save-edit-button
            :saved="contact.isEditing"
            class="mr-5"
            @click="saveContact(contact)"/>
          <button 
            class="button is-small is-outlined" 
            @click="trash(contact.id)">
            <i class="ti ti-trash"/>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CanLock from '@/Mixins/CanLock'
import CrudHelper from '@/Mixins/CrudHelper'

export default {
  name: 'HospitalContacts',
  mixins: [ CrudHelper, CanLock ],
  data() {
    return {
      form: {},
      opened: false,
      index: false,
      crud: {
        read: {
          action: 'hospital_contacts/FETCH'
        },
        create: {
          action: 'hospital_contacts/CREATE',
          message: { success : 'Hospital contact added!', error: 'Error adding Hospital Contact'}
        },
        update: {
          action: 'hospital_contacts/UPDATE',
          message: { success: 'Hospital Update Sucessful', error: ''}
        },
        delete: { 
          action: 'hospital_contacts/DELETE',
          message: {success: 'Hospital Contact truncated'}
        }
      }
    }
  },
  computed: {
    ...mapState('hospital_contacts', ['contacts'])
  },
  methods: {
    saveContact(contact) {
      if (contact.isEditing) {
        this.set_form(Object.assign({}, contact)).update() 
      }
      contact.toggleEdit()
    },
    validate() {
      return Object.keys(this.form).length === 4
    },
  }
}
</script>