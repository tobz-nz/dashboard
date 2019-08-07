@extends('layouts.app')

@section('title', "Alerts for {$device->name}")

@section('nav-links')
    @include('devices.nav-links')
@endsection

@section('content')
    <header class="content-header">
        <h1>@yield('title')</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">
        @foreach($device->alerts as $alert)
        @include('alerts.form', [
            'route' => route('alerts.update', [$device, $alert]),
            'alert' => $alert,
        ])
        @endforeach

        @include('alerts.form', [
            'route' => route('alerts.store', $device),
            'alert' => new \App\Alert,
        ])
    </div>
@endsection
