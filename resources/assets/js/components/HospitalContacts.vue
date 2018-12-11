<template>
  <section class="cont">
    <!-- create contacts form -->
   
    <div class="level">
      <HoverRevealButton @click="opened = !opened">
        <i 
          slot="icon" 
          :class="{'ti-plus': !opened, 'ti-minus': opened}" 
          class="ti"/>
        <span slot="text">{{ !opened ? 'Add' : 'Close' }}</span>
      </HoverRevealButton>
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
    <div class="menu-label p-5">Hospital Contact List</div>
    <div
      v-for="(contact, index) in contacts"
      :key="index"
      class="card is-hospital m-5">
      <div class="card-content">
        <div 
          v-if="contact.isEditing"
          class="field">
          <div class="control mt-5">
            <input
              v-model="contact.name"
              class="input"
              placeholder="Hospital Name"
              type="text">
          </div>
          <div class="control">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.email" 
              class="h--input" 
              placeholder="Email Address" 
              type="email">
          </div>
          <div class="control">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.location" 
              class="h--input" 
              placeholder="Location" 
              type="text">
          </div>
          <div class="control">
            <input 
              v-if="contact.isEditing" 
              v-model="contact.phone" 
              class="h--input"
              placeholder="Telephone" 
              type="text">
          </div>
        </div>
        <template v-else> 
          <h3 class="title is-5 mt-0">
            <span 
              v-text="(index + 1) + '. ' + contact.name"/>
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
        <div class="level level-right">
          <section>
            <button 
              class="button is-small is-pulled-right is-outlined" 
              @click="trash(contact.id)">
              <i class="ti ti-trash"/>
            </button>
            <save-edit-button
              :saved="contact.isEditing"
              class="mr-5 is-pulled-left"
              @click="saveContact(contact)"/>
          </section>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import CrudHelper from '@/Mixins/CrudHelper'

export default {
  name: 'HospitalContacts',
  mixins: [ CrudHelper ],
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
      if(contact.isEditing) this.update(contact) 
      contact.toggleEdit()
    },
    validate() {
      console.log(Object.keys(this.form).length)
      return Object.keys(this.form).length === 4
    },
  }
}
</script>