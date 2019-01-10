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
	bind(el, binding, vnode) {
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
		el.addEventListener('click', (evt) => {
			if (evt.target.matches('li > a')) {
				changePage(evt)
				changeHash(evt)
			}
		})
		const elms = () => Array.from(el.querySelectorAll('li'))
		const anchors = elms().map(e => e.querySelector('a'))

		const resetLinksState = () => {
			elms().forEach(li => li.classList.remove(activeClass))
		}
		const changePage = (evt) => {
			resetLinksState()
			const { parentElement: li } = evt.target
			!modifiers.prevent || evt.preventDefault()
			li.classList.add(activeClass)
			vnode.context.page = elms().indexOf(li)
		}
		const matchesHash = a => a.getAttribute('href') === window.location.hash
		const changeHash = ({target}) => {
			window.history.replaceState('', '', target.href)
		}
		const clickOnMatched = () => {
			const matchedAnchor = anchors.find(matchesHash)	
			!matchedAnchor ? anchors[0].click() : matchedAnchor.click()
		}
		context.$nextTick(() => setTimeout(clickOnMatched, 1000))
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
	componentUpdated: _.debounce((el, binding) => {
		const props = (binding.value) 
			? {height : '0px'}
			: {paddingBottom: '10px', height: $(el).data('v-height')}
		
		$(el).animate({
			paddingTop: '0px',
			paddingBottom: '0px'
		}, 100, 'linear').animate(props, 300, 'swing', function() {
			binding.value || $(el).height('auto')
		})
	}, 300)
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
		el.style.width = '100%'
		el.style.height = '5px'
		preloadClass.map(p => $(el).addClass(p))
	},
	componentUpdated(el, binding) {
		let {value} = binding
		const showValue = () => $(el).text(value);
		(!_.isEmpty(value) || 'undefined' !== typeof(value)) 
			? window.preloadClass.map(p=> $(el).removeClass(p)) && showValue() : null
	}
})