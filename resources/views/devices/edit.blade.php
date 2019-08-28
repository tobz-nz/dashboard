@extends('layouts.app')

@section('title', 'Edit Device settings')

@section('nav-links')
    @include('devices.nav-links')
@endsection

@section('content')
    <header class="content-header">
        <h1>Device settings</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">
        <form class="device-form w-full" action="{{ route('devices.update', $device) }}" method="post">
            @method('patch')

            @include('devices.form')

            <div class="flex justify-between" style="grid-column:1/-1">
                <button type="submit" class="mb-7 button">Update Device</button>
                <button form="delete-form" type="submit" class="mb-7 button--link danger" onclick="return confirm('Are you REALLY Sure?')">Delete Device</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('devices.destroy', $device) }}" method="post">
            @method('DELETE')
            @csrf
        </form>
    </div>
@endsection
