@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img class="h-12 w-auto" src="https://admin-enterblaze-public.s3.us-east-2.amazonaws.com/logos/ENTERBLAZE_web_logo_condensed_no_outline.png" alt="Enterblaze Comics Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
