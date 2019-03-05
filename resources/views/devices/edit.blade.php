@extends('layouts.app')

@section('title', 'Edit Device settings')

@section('content')
    <header class="content-header">
        <h1>Device settings</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">
        <form class="w-full" action="{{ route('devices.update', $device) }}" method="post">
            @method('patch')

            @include('devices.form')

            <div class="flex justify-between">
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
