@component('mail::message')

Thank You for Your Support! We Will be in contact soon!

{{ $alertInfo['alert_body'] }}




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent