<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="manifest" href="{{ route('webmanifest') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/app-icon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('api') }}">
    @auth
    <meta name="api-token" content="{{ auth()->user()->api_token }}">
    <meta name="push-key" content="{{ config('webpush.vapid.public_key') }}">
    @endauth

    <title>@yield('title', '') - {{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    @routes
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400|Barlow:300,400,500,700" rel="stylesheet" type="text/css">

    <script>
        var appData = {
            user:@json(Auth::user()->only(['id', 'name'])),
            places: @json(config('services.algolia.places'))
        }
    </script>
</head>
<body>
    <div id="app" class="layout--main">
        <nav class="sidebar">
            <header class="sidebar-header py-5 px-4 border-b">
                <a href="{{ route('dashboard') }}">
                    <svg class="logo" role="image">
                        <use xlink:href="{{ asset('images/icons.svg#logo') }}"></use>
                    </svg>
                </a>

                @include('components.device-selector', ['devices' => $devices])
            </header>

            @yield('nav-links')

            <svg class="sidebar-close" width="35px" height="35px" role="button">
                <use xlink:href="{{ asset('images/icons.svg#close') }}"></use>
            </svg>
        </nav>

        <main class="content">
            @include('flash::message')
            @if(!$user->pushEnabled())
            <notification-permission></notification-permission>
            @endif

            @yield('content')

            <div class="sidebar-open">
                <svg width="20" height="20" role="button">
                    <use xlink:href="{{ asset('images/icons.svg#chevron-down') }}"></use>
                </svg>
            </div>
        </main>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </div>

<div class="extras">
    @stack('extras')
</div>

</body>
</html>
