<template>
  <section>
    <section class="content-top-bar">
      <h3>Profile</h3>
    </section>
    <profile-grid 
      :name="user.name" 
      :avatar="user.avatar" 
      :avatar-url="(isPatient() ? avatarUrl : '')">
      <template 
        slot="navigation" 
        class="osq-sidenav p-10">
        <li><a href="#basic">Basic Information</a></li>
        <li><a href="#annual">Annual Medical Check</a></li>
        <li><a href="#medical">Medical History</a></li>
        <li><a href="#hospitalize">Hospitalization</a></li>
        <li><a href="#immunization">Immunization</a></li>
        <li><a href="#allergies">Allergies</a></li>
        <li><a href="#family">Family Medical History</a></li>
        <!-- <li><a href="#log">Health Log</a></li> -->
        <li><a href="#contacts">Emergency Contacts</a></li>
        <li><a href="#hospital-contacts">Hospital Contacts</a></li>
        <li><a href="#insurance">Health Insurance Providers</a></li>
      </template>
      <template slot-scope="pager">
        <pager :current="pager.page">
          <div 
            slot="p1" 
            class="">
            <PatientBio :can-edit="isPatient()"/>  
          </div>
          <div slot="p2">
            <h3 class="menu-label">Annual Medical Check</h3>
            <MedicalCheckup 
              v-if="pager.page === 1" 
              :can-edit="!isPatient()"/>
          </div>
          <!-- MEDICAL HISTORY -->
          <section slot="p3">
            <div class="menu-label">Medical History</div>
            <MedicalHistory 
              v-if="pager.page === 2" 
              :can-edit="true"/>
          </section>
          <!-- HOSPITALIZATION -->
          <section slot="p4">
            <div class="menu-label">HOSPITALIZATION</div>
            <Hospitalizations :can-edit="true"/>
          </section>
          <!-- Immunization -->
          <section slot="p5">
            <div class="menu-label">IMMUNIZATIONS</div>
            <Immunizations 
              v-if="pager.page === 4" 
              :can-edit="true"/>
          </section>
          <!-- ALLERGIES -->
          <section slot="p6">
            <div class="menu-label">ALLERGIES</div>
            <Allergies 
              v-if="pager.page === 5" 
              :can-edit="true"/>
          </section>
          <!-- FAMILY MEDICAL HISTORY -->
          <section slot="p7">
            <div class="menu-label">FAMILY MEDICAL HISTORY</div>
            <FamilyMedicalRecords :can-edit="true"/>
          </section>
          <section slot="p8">
            <div class="menu-label">EMERGENCY CONTACTS</div>
            <EmergencyContacts :can-edit="isPatient()"/>
          </section>
          <!-- HOSPITAL CONTACTS -->
          <section slot="p9">
            <div class="menu-label">HOSPITAL CONTACTS</div>
            <HospitalContacts :can-edit="isPatient()"/>
          </section>
          <!-- HEALTH INSURANCE PROVIDERS -->
          <section slot="p10">
            <div class="menu-label">HEALTH INSURANCE PROVIDER</div>
            <HealthInsuranceProvider :can-edit="isPatient()"/>
          </section>
        </pager>
      </template>
    </profile-grid>
  </section>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import ProfileGrid from '@/components/ProfileGrid.vue'
import Allergies from '@/components/Allergies.vue'
import Immunizations from '@/components/Immunizations.vue'
import MedicalHistory from '@/components/MedicalHistory.vue'
import MedicalCheckup from '@/components/MedicalCheckup.vue'
import HospitalContacts from '@/components/HospitalContacts.vue'
import EmergencyContacts from '@/components/EmergencyContacts.vue'
import HealthInsuranceProvider from '@/components/HealthInsuranceProvider.vue'
import FamilyMedicalRecords from '@/components/FamilyMedicalRecords.vue'
import Hospitalizations from '@/components/Hospitalizations.vue'
import PatientBio from '@/patients/PatientBio.vue'

export default {
  name: 'Profile',
  components: {
    PatientBio,
    ProfileGrid, HealthInsuranceProvider, MedicalCheckup,
    Hospitalizations, HospitalContacts, Allergies, 
    MedicalHistory, EmergencyContacts, FamilyMedicalRecords,
    Immunizations
  },
  data() {return {
    avatarUrl: '/api/patient/profile/update/image',
  }},
  computed: {
    user() {
      return this.isDoctor() 
        ? this.patient
        : this.getUser
    },
    ...mapGetters(['getUser']),
    ...mapState('manage_patient', {
      patient: 'currentPatient',
      patients: 'patients'
    }),
  },
  watch: {
    patients(a, b) {
      console.log('Updated the Patients', a, b)
      this.setAsDoctor()
    }
  },
  created () {
    document.title = 'Profile | CleanHelt'
    if (this.isDoctor())
      this.setAsDoctor()
  },
  methods: {
    setAsDoctor() { 
      const { patient_id } = this.$route.params
      if (this.patients.length === 0) return
      this.$store.commit('manage_patient/set_current_patient', patient_id)
    }
  }
}
</script>