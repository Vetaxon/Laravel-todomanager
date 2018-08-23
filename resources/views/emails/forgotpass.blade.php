@component('mail::message')
Dear, {{$user['name']}}

You are receiving this email because we received your request to reset your password.

Use email as a login: {{ $user['email'] }}.

Here are your new password: {{ $user['newpass'] }}

Thanks,
{{ config('app.name') }}
@endcomponent