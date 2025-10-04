@component('mail::message')

Thank You for Your Support! We look forward to seeing you at {{ $alertInfo['event_name'] }}. We will be in contact soon!

{{ $alertInfo['alert_body'] }}




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent