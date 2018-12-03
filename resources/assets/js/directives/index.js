import Vue from 'vue'
import $ from 'jquery'
import _ from 'lodash'

const preloadClass = ['slide', 'content-preloader']

Vue.directive('height', {
	bind(el, binding, vnode) {
		let {when} = binding.modifiers
		if('undefined' == vnode.children || vnode.children.length > 1) {
			console.warn('v-height requires a root node.')
		}
		if(when) {
			el.style.height = '0px'
		}
	},
	componentUpdated(el, binding, vnode) {
		let child = $(vnode.children[0].elm),
			{when} = binding.modifiers
		if(binding.value) {
			el.style.height = when ? child.outerHeight() + 'px' : '0px'
		}else{
			if(when) {
				el.style.height = '0px'
			}
		}
	}
})

Vue.directive('pager-controls', {
	// bind(el, binding, vnode) {
	// },
	bind(el, binding, vnode) {
		console.log(binding)
		const {context} = vnode
		const {modifiers} = binding
		const {activeClass} = binding.value || {
			'activeClass': 'is-active'
		}

		if('undefined' ===  typeof context.page) {
			console.warn('Data Reference Error: Data "page" not Found')
			return false
		}
		if(typeof activeClass === 'undefined') {
			throw Error('Missing required prop `activeClass` for pager-controls')
		}
		$(el).delegate('li > a', 'click', function(evt) {
			!modifiers.prevent || evt.preventDefault()
			$(el).find(`li.${activeClass}`).each((index, elem) => $(elem).removeClass(activeClass))
			$(this).parent().addClass(activeClass)
			vnode.context.page = $(this).parent().index()        
		})
		$(el).find('li:first-child > a').click()
	}
})

Vue.directive('slide', {
	bind(el) {
		el.style.overflow = 'hidden'
	},
	inserted(el) {
		$(el).data('v-height', $(el).height())
		$(el).height(0)
	},
	update(el, binding) {
		const props = (binding.value) 
			? {height : '0px'}
			: {paddingBottom: '10px', height: $(el).data('v-height')}
		$(el).animate({
			paddingTop: '0px',
			paddingBottom: '0px'
		}, 100, 'linear').animate(props, 300, 'swing', function() {
			binding.value || $(el).height('auto')
		})
	}
})

Vue.directive('checkbox', {
	bind(el, binding) {
		let {value} = binding
		$(el).addClass('zmdi').addClass(value ? 'zmdi-check-square': 'zmdi-square-o')
	},
	update (el, binding) {
		let {value} = binding,
			a = '',
			b = ''
		const toggle = () => {
			a = value ? 'zmdi-check-square' : 'zmdi-square-o'
			b = value ? 'zmdi-square-o' : 'zmdi-check-square'
		}
		toggle()
		$(el).addClass(a).removeClass(b)
	}
})

Vue.directive('preload', {
	bind: function (el) {
		// let {sm} = binding.modifiers
		preloadClass.map(p => $(el).addClass(p))
	},
	componentUpdated(el, binding) {
		let {value} = binding
		const showValue = () => $(el).text(value);
		(!_.isEmpty(value) || 'undefined' !== typeof(value)) 
			? window.preloadClass.map(p=> $(el).removeClass(p)) && showValue() : null
	}
})
