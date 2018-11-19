<template>
	<section :class="'va-'+align" id="page-holder" style="overflow: hidden;width: 100%;">
		<div id="page-slider" :style="{width: slideWidth, left: slideLeft}">
			<v-scrollbar class="page" :key="index" :style="{width:`${100 / pageCount}%`}" v-for="(p, index) in pages">
				<slot :name="'p'+(index+1)"></slot>
			</v-scrollbar>
		</div>
	</section>
</template>

<script>
	export default {
		name: 'Pager',
		props: {
			'current': {type: Number, default: 0, required: true}, 
			'align': {type: String, default: 'top'},
		},
		created() { this.$parent.page = 0 },
		data() {return {
			cp: 0,
			parentStyle: {}
		}},
		computed: {
			slideLeft() { return `-${(100 * this.cp)}%` },
			slideWidth() { return Math.abs(this.pageCount * 100) + '%' },
			pageCount() { return Object.keys(this.$slots).length },
			pages() { return Array(this.pageCount).fill("") },
		},
		updated () {
			console.log('Pager Updated!');
			// let parent = this.$el,
			// 	currentPageSelector = `.page:nth(${this.cp})`;
			// const padding = () => parseInt(parent.style.paddingTop) + parseInt(parent.style.paddingBottom);
			// let pagerHeight = parent.querySelector(currentPageSelector).offsetHeight;
			// this.parentStyle = Object.assign({
			// 	height: pagerHeight + padding() +'px'
			// }, this.parentStyle)
		}, 
		watch: {
			current () {
				let {pageCount, current} = this;
				const isWithIn = () => current < pageCount && current >= 0;
				this.cp = typeof(current) === "boolean" 
					? (current ? 1 : 0)
					: !isWithIn() ? this.cp : current;
			}
		}
	}
</script>

<style scoped lang="scss">
	@import '../../sass/components/_animations.scss';

	#page-holder {
		height: 100%;

		#page-slider {
			display: inline-flex;
			height: 100%;
			margin:0;
			position: relative;
			transition: all .3s $ease-in-end;
		}

		.page {
			display: inline-block;
			margin-left: 0px;
			height: 100%;
			&:first-child {
				margin-left: 0;
			}
		}

		@each $align in ('middle','top','bottom','baseline') {
			&.va-#{$align} {
				.page {
					vertical-align: #{$align};
				}
			}
		}
	}
</style>
