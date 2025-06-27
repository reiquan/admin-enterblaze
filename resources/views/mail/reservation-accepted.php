@component('mail::message')

{{ $alertInfo['alert_receipt'] }}

{{ $alertInfo['alert_body'] }}



Thanks,<br>
{{ config('app.name') }}
@endcomponent