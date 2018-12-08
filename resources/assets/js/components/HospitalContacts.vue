<template>
  <section>
    <!-- create contacts form -->
   
    <div 
      class="level" 
      style="align-items: center">
      <span class="title is-6 mb-0">Add a Hospital Contact</span>
      <HoverRevealButton
        @click="opened = !opened">
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
    <div
      v-for="(contact, index) in contacts"
      :key="index"
      class="card is-hospital m-5">
      <div class="card-content">

      	<button class="button is-pulled-right is-small is-outlined" @click="trash(contact.id)">
      		<i class="ti ti-trash"/>
      	</button>
        <save-edit-button
          :saved="contact.isEditing"
          class="mr-5" 
          @click="saveContact(contact)"/>

        <h3 class="title is-5 mt-0">
          <div 
            v-if="contact.isEditing"
            class="field is-horizontal">
            <div class="field">
            	<div class="control">
		            <input
		              v-model="contact.name"
		              class="input" 
		              type="text">
            	</div>
            </div>
          </div>
          <span 
            v-else 
            v-text="(index + 1) + '. ' + contact.name"/>
        </h3>
        <p>
          <i class="ti ti-email mr-10"/>
          <input v-if="contact.isEditing" class="h--input" type="email" v-model="contact.email"/>
          <span v-else class="osq-text-green">{{ contact.email }}</span>
        </p>
        <p>
          <i class="ti ti-mobile mr-10"/>
          <input v-if="contact.isEditing" class="h--input" type="text" v-model="contact.phone"/>
          <span v-else class="osq-text-green">{{ contact.phone }}</span>
        </p>
        <p>
        	<i class="ti ti-home mr-10"/>
          <input v-if="contact.isEditing" class="h--input" type="text" v-model="contact.location"/>
        	<span v-else> {{ contact.location }} </span>
        </p>
      </div>
    </div>
  </section>
</template>

<style>
	.h--input {
    border: none;
    outline: none;
    border-bottom: solid 2px #ddd;
    width: calc(100% - 50px);
    padding: 15px 0px;
	}
</style>

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
	mounted() {
		this.$store.dispatch('hospital_contacts/FETCH')
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