<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Scripts -->
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
                <svg style="--icon-fill: var(--white);margin: 0 auto;width: 130px;height: 40px;display: block;">
                    <use xlink:href="{{ asset('images/icons.svg#logo') }}"></use>
                </svg>

                @include('components.device-selector', ['devices' => auth()->user()->devices])
            </header>

            <ul class="p-4 links unlist">
                <li><a class="link" href="{{ route('dashboard') }}">Trends <span class="line"></span></a></li>
                <li><a class="link" href="{{ route('dashboard') }}">Manage Refills <span class="line"></span></a></li>
                <li><a class="link" href="{{ route('dashboard') }}">Alerts <span class="line"></span></a></li>
                @isset($device)
                <li><a class="link" href="{{ route('devices.edit', $device) }}">Settings <span class="line"></span></a></li>
                @endisset
            </ul>

            <div class="grid">
                <div class="flex py-5 px-4 gap-3 items-center text-2">
                    <img class="mr-4 rounded-lg" width="40" src="{{ auth()->user()->avatar }}" alt="">
                    <div class="grid gap-1">
                        <a class="link" href="{{ route('account') }}">Account</a>
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
</body>
</html>
