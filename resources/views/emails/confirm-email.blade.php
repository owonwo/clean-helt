@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => route('doctor.register.confirm',['token' => $doctor->token])])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
