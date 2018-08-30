import Vue from 'vue'
import Vuex from 'vuex'
import VueMoment from 'vue-moment'
import Router from 'vue-router'
import Admin from '@/Admin.vue'
import Doctor from '@/Doctor.vue'
import Hospital from '@/Hospital.vue'
import Patient from '@/Patient.vue'
 
Vue.use(Router)
Vue.use(VueMoment)

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

Vue.directive('slide-u', {
    bind(el, binding, vnode) {
        $(el).css({overflow: 'hidden'});
    },
    update(el, binding, vnode) {
        if(!binding.value) {
            $(el).animate({
                paddingTop: '0px',
                paddingBottom: '0px'
            }, 100, 'linear').animate({height : '0px'}, 300, 'swing');
        }
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
        $(el).text('LOREM IPSUM');
    },
    componentUpdated(el, binding) {
        let {value} = binding;
        const showValue = () => $(el).text(value);
        (!_.isEmpty(value) || 'undefined' !== typeof(value)) 
            ? window.preloadClass.map(p=> $(el).removeClass(p)) && showValue() : null;
    }
});

Vue.mixin({
    filters: {
        ucfirst (value) {
            return _.capitalize(value);
        }
    }
});

new Vue({
	el: "#app",
    store,
	components: {Admin, Doctor, Hospital, Patient},
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
