<!DOCTYPE html>
<html>
<head>
	<title>CleanHelt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
  <link rel="manifest" href="{{asset('/cleanhelt.webmanifest')}}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.min.css">
	<script defer src="{{ asset('js/app.js') }}"></script>
</head>

<style>
	[v-cloak] {
		display: none;
	}
</style>

<body>
	<main id="app" v-cloak>
		<section id="{{ auth($guard)->user()->chcode }}" is="{{ $guard }}"></section>
		<notifications :position="['bottom', 'center']"></notifications>
		<wg-dialog ref="dialog">
	</main>
</body>
</html>
