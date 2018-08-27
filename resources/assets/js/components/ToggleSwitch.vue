<template>
	<div @click="toggle()"
		:class="[state ? 'on' : 'off', $props.size]" class="switch"></div>
</template>

<style lang="scss">
	$color: #20B171;

	.switch {
		width: 60px;
		height: 30px;
		background: #ccc;
		position: relative;
		border-radius: 30px;
		display: inline-block;
		vertical-align: middle;
		transition: background .3s ease-out .15s;

		&::after {
			content: "";
			background: white;
			border-radius: 50%;
			position: absolute;
			transition: all .3s ease-out;
		}

		/*small size*/
		&.sm {
			height: 20px;
			width: 40px;
		}

		&.sm::after {
			left: 2px;
			top: 2px;
			width: 16px;
			height: 16px;
			background: white;
			box-shadow: 0 0 ;
			border: none !important;
			background-clip: padding-box;
			box-sizing: border-box;
		}
		&.sm.on {
			background: $color;

			&::after {
				left: calc(100% - 20px);
			}
		}


		/* medium size */
		&.md::after {
			top: -2px;
			left: 0;
			right: 0;
			width: 34px;
			height: 34px;
			box-shadow: 0 0 3px rgba(0,0,0, .3);
			border: solid 2px #ddd;
		}
		&.md.on {
			background: $color;

			&::after {
				border: solid 2px $color;
				left: calc(100% - 34px);
			}
		}
	}
</style>

<script>
	export default {
		props: {
			value: {type: Boolean, required: true, default: false },
			size: {type: String, default: "md" }
		},
		mounted() { this.state = this.$props.value },
		data() {return {
			state: false,
		}},
		methods: {
			toggle() {
				this.state = !this.state 
				this.$emit('change', this.state);
			}
		}
	}
</script>
