@can('create', App\Device::class)
<details class="select-device autoclose">
    <summary>
        <div class="summary">
            <span class="grid gap-1 align-items-center"@isset($device) style="--columns:16px auto"@endisset>
                @isset($device)
                <svg width="16" height="16">
                    <use href="#color-for-{{ $device->uid }}"></use>
                </svg>
                @endisset
                <span class="truncate">{{ $device->name ?? 'Select Device' }}</span>
            </span>
            <svg width="30" height="17">
                <use href="{{ asset('images/icons.svg#chevron-down') }}"></use>
            </svg>
        </div>
    </summary>
    <div>
        @foreach($devices as $currentDevice)
        <a href="{{ route('devices.show', $currentDevice) }}" class="grid gap-1 justify-start align-items-center" style="--columns: 20px auto" title="{{ $currentDevice->name }}">
            <svg id="color-for-{{ $currentDevice->uid }}" width="16" height="16" viewBox="0 0 20 20">
                <circle r="8" cx="50%" cy="50%" fill="{{ $currentDevice->color }}" stroke="black"></circle>
            </svg>
            <span>{{ $currentDevice->name }}</span>
        </a>
        @endforeach
        @can('create', App\Device::class)
        <a href="{{ route('devices.create') }}" class="pt-3 border-t link link--new" title="Add new Water Monitor">Add new Water Monitor</a>
        @endcan
    </div>
</details>
@endcan
