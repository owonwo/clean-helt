<template>
  <section 
    :class="{'is-active': active}" 
    class="dropdown is-right">
    <div 
      class="dropdown-trigger" 
      @click="active = !active">
      <slot name="button">
        <button 
          class="button" 
          aria-haspopup="true" 
          aria-controls="dropdown-menu">
          <slot name="content"/>
          <span class="icon is-small">
            <slot name="icon">
              <i 
                class="ti ti-more" 
                aria-hidden="true"/>
            </slot>
          </span>
        </button>
      </slot>
    </div>
    <div 
      id="dropdown-menu" 
      class="dropdown-menu" 
      role="menu" 
      @click="active = !active">
      <div class="dropdown-content">
        <slot name="list"/>
      </div>
    </div>
  </section>
</template>
<script>
export default {
	name: 'Dropdown',
	data() {
		return {
			active: false,
		}
	},
}
</script>