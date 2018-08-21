@component('mail::message')
# {{$doctor->first_name}} {{$doctor->last_name}}

Your have been verified as an authentic doctor. Please proceed to your dashboard

@component('mail::button', ['url' => '/'])
Login to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
