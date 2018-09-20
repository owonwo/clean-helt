import Vue from 'vue';
import GlobalComponents from '@/components';

Vue.prototype.$http = axios;

Vue.mixin({
    components: {...GlobalComponents},
    methods: {
        testChCode(chcode = "") {
            return RegExp('^CH(P|H|D|L|F)([0-9]{9})$').test(chcode);
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
