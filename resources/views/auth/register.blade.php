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

        <div class="input-group grid mb-4 @if($errors->has('dimensions.address'))input--invalid @endif">
            <label class="input-label" for="place">{{ __('Address') }}</label>
            <places-field class="input-field" id="place" name="place" data-field="address-location" value="{{ old('place') }}" placeholder="e.g. 12 Kagan Ave, Mangawhai" data-place required></places-field>

            <input type="hidden" id="address-name" name="address[name]" value="{{ old('address.name') }}">
            <input type="hidden" id="address-city" name="address[city]" value="{{ old('address.city') }}">
            <input type="hidden" id="address-country" name="address[country]" value="{{ old('address.country') }}">
            <input type="hidden" id="address-postcode" name="address[postcode]" value="{{ old('address.postcode') }}">
            <input type="hidden" id="address-latlng-lat" name="address[latlng][lat]" value="{{ old('address.latlng.lat') }}">
            <input type="hidden" id="address-latlng-lng" name="address[latlng][lng]" value="{{ old('address.latlng.lng') }}">

            @if ($errors->has('address') || $errors->has('place'))
                <div class="input--error">{{ $errors->first('place') ?: $errors->first('address') }}</div>
            @endif
        </div>

        <div class="input-group grid mb-6">
            <label class="input-label" for="household-size">{{ __('Household Size(number of residents)') }}</label>
            <input class="input-field" type="number" min="1" id="household-size" name="household_size" value="{{ old('household_size', 3) }}" required>
        </div>

        <button type="submit" class="w-full button button--primary border">{{ __('Register') }}</button>

        <a href="{{ route('login') }}" class="flex p-4 link justify-center">or Login in</a>
    </form>
</div>

@endsection

@push('scripts', '<script src="https://cdn.jsdelivr.net/npm/places.js@1.16.4"></script>')
