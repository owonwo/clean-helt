import Vue from 'vue';
import GlobalComponents from '@/components';

Vue.prototype.$http = axios;
/*
   freezes the profile object after adding
*/
const lockProfile = (person) => {
    person = personalify(person)
    return Object.freeze(person);
}

const personalify = (person) => {
    const person_proto = {
        get name () {
            return [this.first_name,this.last_name].join(' ').trimEnd();
        },
        get fullname () {
            return [this.first_name, this.middle_name, this.last_name].join(' ').trimEnd();
        },
        get full_name() {
            return this.fullname;
        }
    }

    return _.extend(Object.create(person_proto), person);
}

Vue.mixin({
    components: {...GlobalComponents},
    methods: {
        testChCode(chcode = "") {
            return RegExp('^CH(P|H|D|L|F)([0-9]{9})$').test(chcode);
        },
        chcodeIs: (prefix, chcode) => chcode.match(RegExp(`^${prefix}`)) !== null,
        personalify(e) {
            const {chcodeIs} = this;
            return chcodeIs('CHP', e.chcode) || chcodeIs('CHD', e.chcode) ? personalify(e) : e;
        },
        error_message() {
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
