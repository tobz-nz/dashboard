<svg class="battery" width="20" height="20">
    <use href="{{ asset("images/icons.svg#battery-{$device->batteryLevel}") }}"></use>
</svg>

@if ($charging ?? false === true)
    Battery is charging {{ $percent ?? '?' }}%
@endif
