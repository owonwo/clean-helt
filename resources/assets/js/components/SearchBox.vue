<template>
  <div class="osq-search-field control has-icons-right">
    <input class="input" v-model="searchString" @keyup.prevent="$emit('value', searchString)" type="text" :class="$props.shape" :placeholder="$props.placeholder">
    <span class="icon osf osf-search is-small is-right">
    </span>
  </div>
</template>

<script>
  export default {
    name: 'SearchBox',
    props: ['placeholder', 'list', 'value','shape'],
    data () {
      return {
        searchString: '',
      };
    },
    methods: {}
  }
</script>
