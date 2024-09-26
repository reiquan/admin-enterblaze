@component('mail::message')


{{ $alertInfo['alert_body'] }}





Thanks,<br>
{{ config('app.name') }}
@endcomponent