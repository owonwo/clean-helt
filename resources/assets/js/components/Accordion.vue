<style lang="scss" scoped>
	@import '../../sass/base/_colors.scss';
	@import '../../sass/components/_animations.scss';

	.accord {
		.accord-heading {
			color: $dark;
			background-color: #fff;
			margin: 0;
			-webkit-user-select: none;
			display: block;
			position: relative;
			z-index: 3;
			border-bottom: solid 1px fade-out(black, .92);
			transition: all .3s ease-out .3s;
			cursor: pointer;

			&.active {
				color: $primary-color;
				border-bottom-width: 0px;
				background-color: #fff;
				box-shadow: 0 3px 5px -2px rgba(black, .4);
			}
		}

		article.see {
			background: rgba(0, 255, 0, 0.27); 
		}

		article.content {
			color: #333;
			display: block;
			overflow: hidden;
				background-color: #f8f8f8;
			transition: height .3s $linear-in-slow-out;

			.inner-content {
				padding:0 15px;
			}
		}
	}
</style>
<template>
	<section @dragenter.prevent="dragOpen" class="accord">
		<h4 :class="{active:!hideContent}" class="accord-heading container-fluid" @click="toggleContent">
			<slot name="heading">Lorem ipsum.</slot>
			<div class="is-pulled-right">
				<i class="ti" :class="{
					'ti-angle-down': hideContent, 
					'ti-angle-up': !hideContent
				}"></i>
			</div>
		</h4>
		<article v-height.when="!hideContent" class="content">
			<slot name="content" class="inner-content">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa blanditiis qui sint ab obcaecati. Aut nihil fugit voluptatibus temporibus odit sequi, ratione facere velit optio, iusto, eveniet dolor recusandae excepturi.
			</slot>
		</article>
	</section>
</template>

<script>
	export default {
		props: {
			show: {
				type: Boolean,
				default: false
			}
		},
		mounted () {
			this.hideContent = this.$props.show; 
			this.toggleContent()
		},
		data() {return {
			hideContent: true,
			holdDuration: 1000, //dragover open duration
		}},
		methods: {
			dragOpen() {
				setTimeout(e => {
					this.hideContent = false;
				}, this.holdDuration);
			},
			hasContent() {
				return Object.keys(this.$slots['content'][0].children).length > 0;
			},
			toggleContent () {
				this.hideContent = this.hasContent() ? !this.hideContent : true;
			}
		}
	}
</script>
