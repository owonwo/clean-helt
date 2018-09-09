@extends('auth.base')

@section('content')
<div id="osq-login">
    <section class="has-text-centered">
        <img class="logo" src="{{ asset('/images/assets/logo-full@4.png') }}" alt="">
       	<p class="mt-50 mb-15">Login into your account</p>
        <div class="field">
            <input placeholder="Email..." class="input" type="text" name="email" id="email">
        </div>
        <div class="field">
            <input placeholder="Password..." class="input" type="password" name="password" id="password">
        </div>
        <button type="submit" class="button is-submit">LOGIN</button>
       	<div class="mt-15">Not Registered with CleanHelt?</div>
       	<small><a href="{{ url('/register') }}">Sign Up Here</a></small>
    </section>
</div>
@stop
