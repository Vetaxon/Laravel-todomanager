@component('mail::message')
Dear, {{$user['name']}}

You are receiving this email because we received a signup request for your this mail account.


If you did not request a signup , no further action is required.

Thanks,
{{ config('app.name') }}
@endcomponent