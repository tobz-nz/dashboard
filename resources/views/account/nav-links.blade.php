<ul class="p-4 links unlist">
    <li><a class="link{{ Route::currentRouteNamed('profile.index') ? ' active' : '' }}" href="{{ route('profile.index') }}">Profile<span class="line"></span></a></li>
    <li><a class="link{{ Route::currentRouteNamed('profile.edit') ? ' active' : '' }}" href="{{ route('subscription.index') }}">Subscription<span class="line"></span></a></li>
</ul>
