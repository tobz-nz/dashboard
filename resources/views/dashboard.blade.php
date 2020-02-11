@extends('layouts.app')

@section('title', 'Dashboard – '.config('app.name'))

@section('content')

<ul class="devices">
    @foreach(auth()->user()->devices as $currentDevice)
    <li><a href="{{ route('devices.show', $currentDevice) }}">{{ $currentDevice->name }}</a></li>
    @endforeach
</ul>

@endsection
