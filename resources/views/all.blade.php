<!DOCTYPE html>
<html>
<head>
	<title>Clean Helt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
	<script defer src="{{ asset('js/app.js') }}"></script>
</head>
<style>
	[v-cloak] {
		display: none;
	}
</style>

<body>
	<main id="app" v-cloak>
		<section is="{{ $user }}"></section>
	</main>
</body>
</html>
