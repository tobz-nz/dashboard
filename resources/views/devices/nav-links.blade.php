<ul class="p-4 links unlist">
    @isset($device)
        <li><a class="link{{ Route::currentRouteNamed('devices.show') ? ' active' : '' }}" href="{{ route('devices.show', $device) }}">Trends<span class="line"></span></a></li>
        {{-- <li><a class="link{{ Route::currentRouteNamed('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">Manage Refills<span class="line"></span></a></li> --}}
        <li><a class="link{{ Route::currentRouteNamed('alerts.index') ? ' active' : '' }}" href="{{ route('alerts.index', $device) }}">Alerts<span class="line"></span></a></li>
        <li><a class="link{{ Route::currentRouteNamed('devices.edit') ? ' active' : '' }}" href="{{ route('devices.edit', $device) }}">Settings<span class="line"></span></a></li>
    @endisset
</ul>

<div class="account-links">
    <a href="{{ route('profile.index') }}">
        <img class="avatar" width="40" src="{{ auth()->user()->avatar }}" alt="">
    </a>
    <div class="grid gap-1">
        <a class="link" href="{{ route('profile.index') }}">Account</a>

        @impersonating
            <a href="{{ route('impersonate.leave') }}">Leave impersonation</a>
        @else
            <button form="logout-form" class="link">Log Out</button>
        @endImpersonating
    </div>
</div>
