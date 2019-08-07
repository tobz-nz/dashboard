<ul class="p-4 links unlist">
    <li><a class="link{{ Route::currentRouteNamed('profile.index') ? ' active' : '' }}" href="{{ route('profile.index') }}">Profile<span class="line"></span></a></li>
    <li><a class="link{{ Route::currentRouteNamed('subscription.index') ? ' active' : '' }}" href="{{ route('subscription.index') }}">Subscription<span class="line"></span></a></li>
</ul>

<a class="link link--back mb-4 p-4 pl-0 mx-auto" href="{{ route('dashboard') }}">
    <svg width="20" height="20">
        <use xlink:href="{{ asset('images/icons.svg#chevron-left') }}"></use>
    </svg>
    <span>Back</span>
</a>
