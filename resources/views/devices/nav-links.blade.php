<ul class="p-4 links unlist">
    @isset($device)
        <li><a class="link{{ Route::currentRouteNamed('devices.show') ? ' active' : '' }}" href="{{ route('dashboard') }}">Trends<span class="line"></span></a></li>
        {{-- <li><a class="link{{ Route::currentRouteNamed('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">Manage Refills<span class="line"></span></a></li> --}}
        <li><a class="link{{ Route::currentRouteNamed('alerts.index') ? ' active' : '' }}" href="{{ route('alerts.index', $device) }}">Alerts<span class="line"></span></a></li>
        <li><a class="link{{ Route::currentRouteNamed('devices.edit') ? ' active' : '' }}" href="{{ route('devices.edit', $device) }}">Settings<span class="line"></span></a></li>
    @endisset
</ul>

<div class="account-links">
    <img class="avatar" width="40" src="{{ auth()->user()->avatar }}" alt="">
    <div class="grid gap-1">
        <a class="link" href="{{ route('profile.index') }}">Account</a>
        <button form="logout-form" class="link">Log Out</button>
    </div>
</div>