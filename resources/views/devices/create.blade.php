@extends('layouts.app')

@section('content')
    <h1 class="px-8 pb-5 border-b" style="--border-color:var(--grey-4)">Device settings</h1>

    <div class="mb-10 pt-7 px-8 flex flex-col items-start">
        <form class="w-full" action="{{ route('devices.store', $device) }}" method="post">

            <div class="mb-4 input-group inline items-center @if($errors->has('uid'))input--invalid @endif">
                <label for="name">{{ __('Device Code') }}</label>
                <input class="input" type="text" id="uid" name="uid" value="{{ old('uid', $device->uid) }}" placeholder="e.g. 3b9685ec7bee" required>
                @if ($errors->has('uid'))
                    <div class="input--error">{{ $errors->first('uid') }}</div>
                @endif
            </div>

            @include('devices.form')

            <button type="submit" class="mb-7 button">Add Device</button>
        </form>
    </div>
@endsection
