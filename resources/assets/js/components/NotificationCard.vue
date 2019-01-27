<template>
  <section 
    :class="[notif_type]" 
    class="notification activity-notification" 
    @click="$emit('click', $event)">
    <div 
      v-if="$props.account !== 'bell'" 
      class="notification-icon">
      <i 
        :class="[icon_name]"
        class="icon"/>
    </div>
    <div class="notification-text">
	    <slot class="content"/>
	    <div class="has-text-right">
		    <small class="notification-time"><slot name="time">Just now</slot></small>	    	
	    </div>
    </div>
  </section>
</template>

<script>
export default {
	props: {
		'type': { type: String, default: 'light' }, 
		'account': { type: String, default: 'bell' },
	},
	data() {return {
		timestamp: {},
		icon: '',
		types: ['info','danger','dark','primary','link','warning','success'],
		default_type: ['light']
	}},
	computed: {
		icon_name() { return this.getIcon() },
		notif_type() {
			const {$props: {type}, types, default_type} = this
			return ['is'].concat(types.includes(type) ? type : default_type).join('-')
		}
	},
	methods: {
		//Gets the icon for the type of notification
		getIcon() {
			return (['osf osf'].concat(this.$props.account).join('-') + '-white') 
		},
	},
}
</script>