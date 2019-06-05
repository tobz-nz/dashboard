@can('create', App\Device::class)
<details class="select-device autoclose">
    <summary>
        <span>{{ $device->name ?? 'Select Device' }}</span>
        <svg width="30" height="17">
            <use href="{{ asset('images/icons.svg#arrow-down') }}"></use>
        </svg>
    </summary>
    <div>
        @foreach($devices as $device)
        <a href="{{ route('devices.show', $device) }}" class="link" title="{{ $device->name }}">{{ $device->name }}</a>
        @endforeach
        @can('create', App\Device::class)
        <a href="{{ route('devices.create') }}" class="pt-3 border-t link link--new" title="Add new Water Monitor">Add new Water Monitor</a>
        @endcan
    </div>
</details>
@endcan
