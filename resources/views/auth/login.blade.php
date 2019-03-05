@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center items-center">
    <img class="block mt-8" width="145" height="145" src="{{ asset('images/icon.svg') }}">

    <p class="mb-6">
        <span class="block text-lg">Log in to <img style="margin:-6px" width="100" src="{{ asset('images/logo.svg') }}"></span>
        or <a href="{{ route('register') }}" class="">{{ __('create an account') }}</a>
    </p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autofocus autocomplete="username">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="input-group mb-4">
            <label class="input-label" for="password">{{ __('Password') }}</label>
            <input class="input-field" type="password" id="password" name="password" placeholder="e.g. I have a long strong password" required autocomplete="current-password">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <label for="remember" class="mb-6 input-group--checkable mb-4">
            <input class="input--checkable" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <path d="M17.5 20h-16c-0.827 0-1.5-0.673-1.5-1.5v-16c0-0.827 0.673-1.5 1.5-1.5h16c0.827 0 1.5 0.673 1.5 1.5v16c0 0.827-0.673 1.5-1.5 1.5zM1.5 2c-0.276 0-0.5 0.224-0.5 0.5v16c0 0.276 0.224 0.5 0.5 0.5h16c0.276 0 0.5-0.224 0.5-0.5v-16c0-0.276-0.224-0.5-0.5-0.5h-16z"></path>
                <path class="checked" d="M7.5 14.5c-0.128 0-0.256-0.049-0.354-0.146l-3-3c-0.195-0.195-0.195-0.512 0-0.707s0.512-0.195 0.707 0l2.646 2.646 6.646-6.646c0.195-0.195 0.512-0.195 0.707 0s0.195 0.512 0 0.707l-7 7c-0.098 0.098-0.226 0.146-0.354 0.146z"></path>
            </svg>

            {{ __('Remember Me') }}
        </label>

        <button type="submit" class="w-full button button--primary border">{{ __('Log In') }}</button>

        <a href="{{ route('password.request') }}" class="link">{{ __('Forgot Your Password?') }}</a>
    </form>
</div>

@endsection
