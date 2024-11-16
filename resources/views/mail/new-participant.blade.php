@component('mail::message')

{{ $alertInfo['alert_receipt'] }}

{{ $alertInfo['alert_body'] }}


@component('mail::button', ['url' => $alertInfo['alert_link']])
{{ __('Join Our Discord Channel For Tournament Updates') }}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent