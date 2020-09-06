@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center align-items-center">
    <svg class="block mt-6" style="color:var(--blue-1)" width="145" height="145">
        <use href="{{ asset('images/icons.svg#icon') }}"></use>
    </svg>
    <svg class="mb-5" width="300" height="80">
        <use href="{{ asset('images/icons.svg#logo') }}"></use>
    </svg>

    <form class="mb-6" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group grid mb-4">
            <label class="input-label" for="name">{{ __('Name') }}</label>
            <input class="input-field" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Arthur Dent" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="input-group grid mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autocomplete="username">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="input-group grid mb-4">
            <label class="input-label" for="password">{{ __('Password') }}</label>
            <input class="input-field" type="password" id="password" name="password" placeholder="e.g. I have a long strong password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="input-group grid mb-4">
            <label class="input-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input class="input-field" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="w-full button button--primary border">{{ __('Register') }}</button>

        <a href="{{ route('login') }}" class="flex p-4 link justify-center">or Login in</a>
    </form>
</div>

@endsection

@push('scripts', '<script src="https://cdn.jsdelivr.net/npm/places.js@1.16.4"></script>')
