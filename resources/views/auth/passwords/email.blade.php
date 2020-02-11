@extends('layouts.bones')

@section('content')

<div class="flex flex-col justify-center align-items-center">
    <img class="block mt-8" width="145" height="145" src="{{ asset('images/icon.svg') }}">
    <img class="block mb-5" width="320" height="100" src="{{ asset('images/logo.svg') }}">

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        @if (session('status'))
            <div class="mb-4 alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="input-group mb-4">
            <label class="input-label" for="email">{{ __('Email Address') }}</label>
            <input class="input-field" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. user@tankful.nz" required autofocus autocomplete="username">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <button type="submit" class="w-full button button--primary border">{{ __('Send Password Reset Link') }}</button>

        <a href="{{ route('login') }}" class="link">{{ __('Cancel') }}</a>

    </form>

</div>

@endsection
