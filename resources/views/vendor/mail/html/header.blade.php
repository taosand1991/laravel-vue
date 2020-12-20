<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'LegacyGraphics')
<img src="https://static.vecteezy.com/system/resources/thumbnails/000/236/297/original/modern-luxury-brand-logo-background.jpg" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
