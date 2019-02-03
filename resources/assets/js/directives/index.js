import Vue from 'vue'
import $ from 'jquery'
import _ from 'lodash'
import {trace} from '@/store/helpers/utilities'

const preloadClass = ['slide', 'content-preloader']

Vue.directive('height', {
  bind(el, binding, vnode) {
    let { when } = binding.modifiers
    if ('undefined' == vnode.children || vnode.children.length > 1) {
      console.warn('v-height requires a root node.')
    }
    if (when) {
      el.style.height = '0px'
    }
  },
  componentUpdated(el, binding, vnode) {
    let child = $(vnode.children[0].elm),
      { when } = binding.modifiers
    if (binding.value) {
      el.style.height = when ? child.outerHeight() + 'px' : '0px'
    } else {
      if (when) {
        el.style.height = '0px'
      }
    }
  }
})

Vue.directive('pager-controls', {
  bind(el, binding, vnode) {
    const { context } = vnode
    const { modifiers } = binding
    const { activeClass } = binding.value || {
      'activeClass': 'is-active'
    }

    if ('undefined' === typeof context.page) {
      console.warn('Data Reference Error: Data "page" not Found')
      return false
    }
    if (typeof activeClass === 'undefined') {
      throw Error('Missing required prop `activeClass` for pager-controls')
    }

    const control = PagerControl(el, {activeClass, modifiers})
    control.init()
    control.addEventListener('change-page', index => vnode.context.page = index)

    context.$nextTick(() => setTimeout(control.autoClickOnMatchedHash.bind(control), 1000))
    context.pagerControl = control
  },
  update(el, binding, vnode) {
    setTimeout(() => {
      vnode.context.pagerControl.updateAnchors()      
    }, 1000)
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
    const props = (binding.value) ? { height: '0px' } : { paddingBottom: '10px', height: $(el).data('v-height') }

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
    let { value } = binding
    $(el).addClass('zmdi').addClass(value ? 'zmdi-check-square' : 'zmdi-square-o')
  },
  update(el, binding) {
    let { value } = binding,
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
  bind: function(el) {
    // let {sm} = binding.modifiers
    el.style.width = '100%'
    el.style.height = '5px'
    preloadClass.map(p => $(el).addClass(p))
  },
  componentUpdated(el, binding) {
    let { value } = binding
    const showValue = () => $(el).text(value);
    (!_.isEmpty(value) || 'undefined' !== typeof(value)) ?
    window.preloadClass.map(p => $(el).removeClass(p)) && showValue(): null
  }
})

const PagerControl = (navEl, {modifiers, activeClass}) => ({
  elms: null, 
  events: [],
  anchors: [],
  init() {
    if (!navEl) throw Error('Invalid Navigation Element given: PagerControlDirective')
      
    this.elms = () => Array.from(navEl.querySelectorAll('li'))
    this.addEventsToAnchors()
    this.navEl = navEl
  },
  addEventsToAnchors() {
    this.elms()
    .map(e => e.querySelector('a'))
    // .map(trace({anchors: this.anchors, message: 'before filter'}))
    .filter(anchor => {
      return !this.anchors.includes(anchor)
    })
    // .map(trace('after filter'))
    .forEach(anchor => {
      this.anchors.push(anchor)
      anchor.addEventListener('click', (evt) => {
        this.updateAnchors()
        this.changePage(anchor)
        this.changeHash(anchor)
      })
    });
  },
  updateAnchors() {
    this.addEventsToAnchors()
  },
  resetLinksState() {
    this.elms().forEach(li => li.classList.remove(activeClass))
  },
  addEventListener (eventname, callback) {
    this.events[eventname] = callback
  },
  changePage (anchor) {
    this.resetLinksState()
    const { parentElement: li } = anchor
    li.classList.add(activeClass)
    this.events['change-page']( this.elms().indexOf(li) )
  },
  matchesHash: (a) => a.getAttribute('href') === window.location.hash,
  changeHash: (anchor) => {
    window.history.replaceState('', '', anchor.href)
  },
  autoClickOnMatchedHash() {
    const matchedAnchor = this.anchors.find(this.matchesHash)
    if (!matchedAnchor && this.anchors.length) {
      this.anchors[0].click()
    } else {
      matchedAnchor.click()
    }
  }
})