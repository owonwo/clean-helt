<!DOCTYPE html>
<html>
<head>
	<title>CleanHelt</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="api-token" content="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImYzZDE3MGRhZmQ2MmUxMTY2ODBmYTYyN2JlNTQyYTc0NDI1NDZiODE3ZTRhMWVmYjRjMWY2OTQxNzhiODQ5YTQ4ZjhiYjUzMGJjMGY5OTFiIn0.eyJhdWQiOiIyIiwianRpIjoiZjNkMTcwZGFmZDYyZTExNjY4MGZhNjI3YmU1NDJhNzQ0MjU0NmI4MTdlNGExZWZiNGMxZjY5NDE3OGI4NDlhNDhmOGJiNTMwYmMwZjk5MWIiLCJpYXQiOjE1MzY5NzgxNTcsIm5iZiI6MTUzNjk3ODE1NywiZXhwIjoxNTM2OTk5NzU2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.NNP8KI55gYBkZTvDqKdBesgUzi30-4MNp-eeb0YcQ94JhIhbYjhr0ymQ7AU3BwrdElG_5wQyEQNvhMhEzbjlS8MtLSlpY9hrZLMGLftogMNK5Ha_XZdI2aOTnandbx2dQiZ_J7jCBl2v088OKJrP5S7qa3T2P51blJ3NU1774mwUN93Rfm6BMCMwVo0Bpuldqrz5xQl24tvhDi9D4xG_059v-IZJ7CqAj2Z-J9NHXewUEhGSxYCC7-rLz8RC5Z9vgYWK2puzY98XFsjHLUa7nvZGMOy6CQaVT_hRBRzuqY5b0DphoakZSK06dGAm6k33QVyzIioVPBGbAVZWcyvpFRhYBtOwQck32BpqSB6t74RGOi71iLOC1qIWau8-u9r6mr1GphYgIBIOPw4-dFDMsBdChswpBqV3Srr3XQGzNw8It4ExX_DXGAj-i4dGd4XI28lcuC1vQTXXxAjoec9c-kdAnkr44y2bewrVfoAITOSoIGiyF6gdC0lhltXaOiXy3R4PHAGc9fQ3ppP2XouvenmvarJaR57F6mED3rNqIVNXxBm_oeZ-F6koUhtHbpVjHUFHSCYoeP5awIzHoEZe0FsGVo4NUVO-r7H2zr10g88ldgtk6PElgCWnoWn-Ec1CVp4Y062AY2f6ipPB9E-SJzbFaiAcNkGbaw-aIZ5IZ8E">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.min.css"> --}}
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
	</main>
</body>
</html>
