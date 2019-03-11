<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="manifest" href="{{ route('webmanifest') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="api-token" content="{{ auth()->user()->api_token }}">
    <meta name="push-key" content="{{ config('webpush.vapid.public_key') }}">
    @endauth

    <title>@yield('title', config('app.name'))</title>

    <!-- Scripts -->
    @routes
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400|Barlow:300,400,500,700" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app" class="layout--main">
        <nav class="sidebar">
            <header class="sidebar-header mb-5 py-5 px-4 border-b">
                <a href="{{ route('dashboard') }}">
                    <svg class="logo" role="image">
                        <use xlink:href="{{ asset('images/icons.svg#logo') }}"></use>
                    </svg>
                </a>

                @include('components.device-selector', ['devices' => auth()->user()->devices])
            </header>

            <ul class="p-4 links unlist">
                <li><a class="link" href="{{ route('dashboard') }}">Trends <span class="line"></span></a></li>
                <li><a class="link" href="{{ route('dashboard') }}">Manage Refills <span class="line"></span></a></li>
                @isset($device)
                <li><a class="link" href="{{ route('alerts.index', $device) }}">Alerts <span class="line"></span></a></li>
                <li><a class="link" href="{{ route('devices.edit', $device) }}">Settings <span class="line"></span></a></li>
                @endisset
            </ul>

            <div class="grid">
                <div class="flex py-5 px-4 gap-3 items-center text-2">
                    <img class="mr-4 rounded-lg" width="40" src="{{ auth()->user()->avatar }}" alt="">
                    <div class="grid gap-1">
                        <a class="link" href="{{ route('account.edit', auth()->user()->account) }}">Account</a>
                        <button form="logout-form" class="link">Log Out</button>
                    </div>
                </div>

            </div>
        </nav>

        <main class="content">
            @if (session('status'))
                <div class="alert alert--{{ session('statusLevel', 'success') }}" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->count())
            <div class="alert alert--error" role="alert">
                {{ $errors->first() }}
            </div>
            @endif

            @yield('content')
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
