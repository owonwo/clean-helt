<template>
  <li class="osq-patient-list">
    <section>
      <img 
        :src="profile.patient.avatar" 
        class="image">
      <div>
        <h4 class="profile-title">{{ profile.patient.first_name }} {{ profile.patient.last_name }} 
          <span 
            v-if="isShared(profile)" 
            class="tag is-info">Shared</span>
        </h4>
        <span class="is-small is-bold menu-label">Share expires {{ profile.expired_at | moment("from", "now") }}</span>
      </div>
    </section>
    <div
      class="level options level-right">
      <button 
        v-if="canShowButton('assigned') && isHospital()"
        class="button is-outlined has-no-motion is-rounded"
        @click="emit('assign', profile)">
        Assign Doctor
      </button>
      <template 
        v-if="isDoctor()">
        <router-link 
          v-if="canShowButton('view')"
          :to="{name: 'patient-profile', params: {chcode: profile.patient.chcode, patient_id: profile.patient.id }}" 
          tag="button" 
          class="button has-no-motion is-primary is-rounded">View</router-link>
        <button 
          v-if="canShowButton('refer')"
          class="button is-outlined has-no-motion is-rounded" 
          @click="$parent.makeRefer(profile.share.id)">
          Refer
        </button>
      </template>
    </div>
  </li>
</template>

<script>
export default {
  name: 'PatientList',
  props: {
    'view': {type: Boolean, default: true},
    'assigned': {type: Boolean, default: true},
    'assigned': {type: Boolean, default: true},
    'profile': {type: Object, required: true}
  },
  data: () => ({}),
  computed: {
    // profile() { return this.$props.profile }
  },
  methods: {
    emit(action, profile) {
      this.$emit('click', {
        action, profile_share_id: profile.id 
      })
    },
    canShowButton(action) {
      return !!this.$props[action]
    },
    isShared: (profile) => {
      if (profile.extensions) 
        return profile.extensions.length > 0
      return false
    }
  }
}
</script>

<style lang="scss">
.osq-patient-list {
    display: flex;
    background: white;
    padding: 15px 10px;
    align-items: center;
    border-bottom: solid 1px #ddd;
    justify-content: space-between;
    
    > section {
        flex-grow: 1;
        display: flex;
        align-items: center;
    }

    .counter, .image {
        margin-right: 15px;
    }

    .counter {
        max-width: 50px;
        padding: 0 10px;
    }
    
    .profile-title {
        font-size: 1.2rem;
    }

    .image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 30px;
        border-radius: 12px;
    }

    .button {
        margin: 0 5px;
        letter-spacing: 1px;
        font-size: 1rem;
        text-transform: uppercase;
    }
}
</style>