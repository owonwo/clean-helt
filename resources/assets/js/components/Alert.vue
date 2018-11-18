<template>
	<section @click="$emit('click', $event)" class="notification" :class="[notif_type]">
		<span v-if="$props.icon !== 'bell'" class="notification-icon is-pulled-left">
			<i class="icon" :class="[icon_name]"></i>
		</span>
		<slot class="content"></slot>
	</section>
</template>

<style scoped>
	.notification {
		padding-top: 1rem;
		padding-bottom: 1rem;
	}
</style>

<script>
export default {
	name: 'Alert',
	props: {
		'type': {type: String}, 
		'icon': {type: String, default: 'bell'},
	},
	computed: {
		icon_name() { return this.getIcon() },
		notif_type() {
			const {$props: {type}, types, default_type} = this;
			return ["is"].concat(types.includes(type) ? type : default_type).join("-");
		}
	},
	methods: {
		//Gets the icon for the type of notification
		getIcon() {
			return (['osf osf'].concat(this.$props.icon).join('-') + '-white'); 
		},
	},
	data() {return {
		timestamp: {},
		icon: "",
		types: ["info","danger","dark","primary","link","warning","success"],
		default_type: ['light'],
	}},
}
</script>
