@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center items-center">
    <img class="block mt-8" width="145" height="145" src="{{ asset('images/icon.svg') }}">
    <img class="block mb-5" width="320" height="100" src="{{ asset('images/logo.svg') }}">

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group mb-4">
            <label class="input-label" for="name">{{ __('Name') }}</label>
            <input class="input-field" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Arthur Dent" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autocomplete="username">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="password">{{ __('Password') }}</label>
            <input class="input-field" type="password" id="password" name="password" placeholder="e.g. I have a long strong password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input class="input-field" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="address">{{ __('Address') }}</label>
            <input class="input-field" type="text" id="address" name="address" data-places required>
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="household-size">{{ __('Household Size(number of residents)') }}</label>
            <input class="input-field" type="number" min="1" id="household-size" name="household_size" required>
        </div>

        <button type="submit" class="w-full button button--primary border">{{ __('Register') }}</button>

    </form>
</div>

@endsection
