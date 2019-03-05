@extends('layouts.app')

@section('title', 'Dashboard – '.config('app.name'))

@section('content')

<ul class="devices">
    @foreach(auth()->user()->devices as $device)
    <li><a href="{{ route('devices.show', $device) }}">{{ $device->name }}</a></li>
    @endforeach
</ul>

@endsection
