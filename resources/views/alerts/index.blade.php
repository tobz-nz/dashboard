@extends('layouts.app')

@section('title', "Alerts for {$device->name}")

@section('content')
<header class="content-header">
    <h1>Alerts for {{ $device->name }}</h1>
</header>

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

@endsection
