<template>
	<section class="notification activity-notification" :class="[notif_type]">
		<span v-if="$props.account !== 'bell'" class="notification-icon is-pulled-left">
			<i class="icon" :class="[icon_name]"></i>
		</span>
		<slot class="content"></slot>
	</section>
</template>

<script>
export default {
	props: {
		'type': {type: String}, 
		'account': {type: String, default: 'bell'},
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
			return (['osf osf'].concat(this.$props.account).join('-') + '-white'); 
		},
	},
	data() {return {
		timestamp: {},
		icon: "",
		types: ["info","danger","dark","primary","link","warning","success"],
		default_type: ['light']
	}}
}
</script>

<style lang="scss">
	.activity-notification {
		display: flex;
		align-items: flex-start;

		&-icon {
			margin-left: -1rem;
			margin-top: 3px;
			margin-right: 1rem;
		}
	}
</style>
