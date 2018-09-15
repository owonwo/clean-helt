import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'
import VueMoment from 'vue-moment'
import Notification from 'vue-notification'

// #pages
import Admin from '@/Admin.vue'
import Doctor from '@/Doctor.vue'
import Patient from '@/Patient.vue'
import Hospital from '@/Hospital.vue'
import Pharmacy from '@/Pharmacy.vue'
import Laboratory from '@/Laboratory.vue'
import GlobalComponents from '@/components';

Vue.use(Router)
Vue.use(VueMoment)
Vue.use(Notification)

import store from '@/store/';

Vue.prototype.$http = axios;

window.preloadClass = ['slide', 'content-preloader'];

Vue.directive('height', {
    bind(el, binding, vnode) {
        let {when} = binding.modifiers;
        if('undefined' == vnode.children || vnode.children.length > 1) {
            console.warn('v-height requires a root node.');
        }
        if(when) {
            el.style.height = '0px';
        }
    },
    componentUpdated(el, binding, vnode) {
        let child = $(vnode.children["0"].elm),
            {when} = binding.modifiers;
        if(binding.value) {
            el.style.height = when ? child.outerHeight() + 'px' : '0px';
        }else{
            if(when) {
                el.style.height = '0px';
            }
        }
    }
});

Vue.directive('pager-controls', {
    // bind(el, binding, vnode) {
    // },
    bind(el, binding, vnode) {
        const {context} = vnode;
        const {value: {activeClass}, modifiers} = binding;

        if("undefined" ===  typeof context.page) {
            console.warn('Data Reference Error: Data "page" not Found')
            return false
        }
        $(el).delegate('li > a', 'click', function(evt) {
            !modifiers.prevent || evt.preventDefault();
            $(el).find(`li.${activeClass}`).each((index, elem) => $(elem).removeClass(activeClass));
            $(this).parent().addClass(activeClass);
            vnode.context.page = $(this).parent().index();        
        });
    }
});

Vue.directive('slide', {
    bind(el, binding, vnode) {
        el.style.overflow = 'hidden'
    },
    inserted(el, binding, vnode) {
        $(el).data('v-height', $(el).height())
        $(el).height(0);
    },
    update(el, binding, vnode) {
        const props = (binding.value) 
            ? {height : '0px'}
            : {height: $(el).data('v-height')}
        $(el).animate({
            paddingTop: '0px',
            paddingBottom: '0px'
        }, 100, 'linear').animate(props, 300, 'swing');
    }
});

Vue.directive('checkbox', {
    bind(el, binding) {
        let {value} = binding;
        $(el).addClass('zmdi').addClass(value ? 'zmdi-check-square': 'zmdi-square-o');
    },
    update (el, binding) {
        let {value} = binding,
            a = '',
            b = '';
        const toggle = () => {
            a = value ? 'zmdi-check-square' : 'zmdi-square-o';
            b = value ? 'zmdi-square-o' : 'zmdi-check-square';
        }
        toggle();
        $(el).addClass(a).removeClass(b);
    }
})

Vue.directive('preload', {
    bind: function (el, binding) {
        let {sm} = binding.modifiers;
        window.preloadClass.map(p => $(el).addClass(p));
    },
    componentUpdated(el, binding) {
        let {value} = binding;
        const showValue = () => $(el).text(value);
        (!_.isEmpty(value) || 'undefined' !== typeof(value)) 
            ? window.preloadClass.map(p=> $(el).removeClass(p)) && showValue() : null;
    }
});

Vue.mixin({
    components: {...GlobalComponents},
    methods: {
        testChCode(chcode = "") {
            return RegExp('^CH(P|H|D|L)([0-9]{9})$').test(chcode);
        }
    },
    filters: {
        testChCode(value = "") {
            return this.testChCode(value)
        },
        ucfirst (value) {
            return _.capitalize(value);
        },
        truncate(value, length) {
            return _.truncate(value, {length});
        }
    }
});

new Vue({
	el: "#app",
    store,
	components: {Admin, Doctor, Hospital, Patient, Pharmacy, Laboratory},
	data: {
	    user: {},
		sidebars: {nav : false, notif: true}
	},
	methods: {
		toggleSidebar() {
			this.sidebars.nav = !this.sidebars.nav;
		},
		toggleNotification() {
			this.sidebars.notif = !this.sidebars.notif;
		},
		getIcon(name) {
			return ['osf osf-'].concat(name.toLowerCase()).join("");
		}
	},
});
