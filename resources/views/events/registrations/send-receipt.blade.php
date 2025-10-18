@component('mail::message')

Thank you for your purchase!

{{ $alertInfo['alert_body'] }}




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent