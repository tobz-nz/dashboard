@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center items-center">
    <img class="block mt-8" width="145" height="145" src="{{ asset('images/icon.svg') }}">
    <img class="block mb-5" width="320" height="100" src="{{ asset('images/logo.svg') }}">

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autofocus autocomplete="username">
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

        <button type="submit" class="w-full button button--primary border">{{ __('Reset Password') }}</button>

    </form>
</div>

@endsection
