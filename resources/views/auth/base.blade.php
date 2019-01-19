<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="theme-color" content="#20B171">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="manifest" href="{{asset('/cleanhelt.webmanifest')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script async src="{{ asset('js/app.js') }}"></script>
<!--     <link defer href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> -->
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
      <notifications :position="['bottom', 'center']" group="register"></notifications>
    </div>
</body>
</html>
