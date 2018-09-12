<template>
  <div class="osq-search-field control has-icons-right">
    <input class="input" type="text" :class="$props.shape" :placeholder="$props.placeholder">
    <span class="icon osf osf-search is-small is-right">
    </span>
  </div>
</template>

<script>
  export default {
    name: 'SearchBox',
    props: ['placeholder', 'list', 'shape'],
    data () {
      return {
      };
    },
    methods: {}
  }
</script>
