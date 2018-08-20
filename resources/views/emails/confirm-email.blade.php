@component('mail::message')
# Introduction

Thanks for registering to Clean Health, We'll Please need you to confirm your email.

@component('mail::button', ['url' => route('doctor.register.confirm',['token' => $doctor->token])])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
