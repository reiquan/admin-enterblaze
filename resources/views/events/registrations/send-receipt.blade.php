@component('mail::message')

Thank You for Your Purchase. We will see you there!!

{{ $alertInfo['alert_body'] }}




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent