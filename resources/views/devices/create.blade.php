@extends('layouts.app')

@section('title', 'Add Device')

@section('nav-links')
    @include('devices.nav-links')
@endsection

@section('content')
    <h1 class="px-8 pb-5 border-b" style="--border-color:var(--grey-4)">Device settings</h1>

    <div class="mb-10 pt-7 px-8 flex flex-col items-start">
        <form class="w-full" action="{{ route('devices.store', $device) }}" method="post">

            <div class="mb-4 input-group inline @if($errors->has('uid'))input--invalid @endif">
                <label class="input-label" for="uid">{{ __('Device Code') }}</label>
                <input class="input-field" type="text" id="uid" name="uid" value="{{ old('uid', $device->uid) }}" placeholder="e.g. 30aea55e7b24" @if($errors->has('uid'))aria-errormessage="error-message-uid" aria-invalid @endif autofocus>
                @if ($errors->has('uid'))
                    <div id="error-message-uid" class="input--error">{{ $errors->first('uid') }}</div>
                @endif
                <div class="input-summary">Enter the code on the side of you device.</div>
            </div>

            @include('devices.form')

            <button type="submit" class="mb-7 button">Add Device</button>
        </form>
    </div>
@endsection
