@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center align-items-center">
    <svg class="block mt-6" style="color:var(--blue-1)" width="145" height="145">
        <use href="{{ asset('images/icons.svg#icon') }}"></use>
    </svg>

    <p class="mb-6">
        <span class="block text-lg">Log in to <svg style="margin:-6px" width="100" height="28">
            <use href="{{ asset('images/icons.svg#logo') }}"></use>
        </svg></span>
        or <a href="{{ route('register') }}" class="underline">{{ __('create an account') }}</a>
    </p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group grid mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autofocus autocomplete="username">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="input-group grid mb-4">
            <label class="input-label" for="password">{{ __('Password') }}</label>
            <input class="input-field" type="password" id="password" name="password" placeholder="e.g. I have a long strong password" required autocomplete="current-password">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <label for="remember" class="mb-6 input-group--checkable mb-4">
            <input class="input--checkable" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="{{ asset('images/icons.svg#checkbox') }}"></use>
                <use class="checked" xlink:href="{{ asset('images/icons.svg#checkbox_checked') }}"></use>
            </svg>

            {{ __('Remember Me') }}
        </label>

        <button type="submit" class="w-full button button--primary border">{{ __('Log In') }}</button>

        <a href="{{ route('password.request') }}" class="link">{{ __('Forgot Your Password?') }}</a>
    </form>
</div>

@endsection
