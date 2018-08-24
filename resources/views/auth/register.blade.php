@extends('auth.base')

@section('content')
<div id="osq-login">
    <section class="has-text-centered">
        <img class="logo" src="{{ asset('/images/assets/logo-full@4.png') }}" alt="">
       	<p class="mt-50 mb-15">Sign up here. Only takes a few minutes</p>
        <div class="field">
            <input placeholder="Full Name" class="input" type="text" name="email" id="email">
        </div>
        <div class="field">
          <select name="" id="" class="input"> 
            <option disabled value="0">Gender...</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="field">
            <input placeholder="Password" class="input" type="password" name="password" id="password">
        </div>
        <div class="field">
            <input placeholder="Phone Number" class="input" type="number" name="phone">
        </div>
        <div class="field">
          <textarea class="textarea" placeholder="Address" rows=2></textarea>
        </div>
        <div class="field">
          <select name="city" class="input">
            <option disabled="">Pick City...</option>
            <option>Port Harcourt</option>
            <option>Town</option>
            <option>Borikir</option>
          </select>
        </div>
        <div class="field">
          <select name="state" class="input">
            <option disabled=""> State...</option>
            <option>Rivers</option>
            <option>Bayelsa</option>
            <option>Delta</option>
          </select>
        </div>
        <div class="field">
          <select class="input" name="country">
            <option disabled=""> Country...</option>
            <option>Nigeria</option>
            <option>Ghana</option>
          </select>
        </div>
        <div class="field">
          <label class="radio">
            <input type="radio" name="foobar">
            SMS
          </label>
          <label class="radio">
            <input type="radio" name="foobar" checked>
            EMAIL
          </label>
        </div>
        <div class="field">
          <select  class="input" name="religion">
            <option disabled="">Select Religion...</option>
            <option>Christainity</option>
            <option>Muslim</option>
            <option>Islam</option>
            <option>Others...</option>
          </select>
        </div>
        <div class="field">
          <select class="input" name="marital_status">
            <option disabled="">Select Marital Status...</option>
            <option>Married</option>
            <option>Single</option>
          </select>
        </div>
        <button type="submit" class="button is-submit">CONTINUE</button>
    </section>
</div>
@stop
