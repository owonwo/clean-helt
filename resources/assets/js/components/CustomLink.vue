<template>
	<router-link :to="$props.to" tag="li">
	    <a href="#"><i :class="[$props.icon]"></i> {{$props.name}}</a>
	</router-link>
</template>

<script>
	export default {
		name: 'CustomLink',
		props: ['to','name', 'icon'],		
	}
</script>
