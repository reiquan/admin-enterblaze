@component('mail::message')

You are on the Waiting List!

{{ $alertInfo['alert_body'] }}




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent