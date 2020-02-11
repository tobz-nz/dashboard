@extends('layouts.bones')

@section('content')
    <div class="p-8 flex flex-col align-items-center">
        <img class="block m-auto" width="70" src="{{ asset('images/icon.svg') }}">
        <img class="block m-auto mb-8" width="130" src="{{ asset('images/logo.svg') }}">

        <form action="{{ route('devices.store') }}" method="post">
            @csrf()

            <div class="mb-4 input-group inline align-items-center">
                <label for="uid">{{ __('Device ID') }}</label>
                <input class="input" type="text" id="uid" name="uid" value="{{ old('uid') }}" placeholder="e.g. 123fgh456" required data-unqiue>
                @if ($errors->has('uid'))
                    <div class="input--error">{{ $errors->first('uid') }}</div>
                @endif
            </div>

            <div class="mb-4 input-group inline align-items-center">
                <label for="name">{{ __('Name') }}</label>
                <input class="input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Main Water Tank">
                @if ($errors->has('name'))
                    <div class="input--error">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-7 input-group inline align-items-center">
                <label for="color">{{ __('Colour') }}</label>
                <input class="input" type="color" id="color" name="color" value="{{ old('color') }}" placeholder="e.g. Main Water Tank">
                @if ($errors->has('color'))
                    <div class="input--error">{{ $errors->first('color') }}</div>
                @endif
            </div>

            <h3>Dimensions</h3>
            <input type="hidden" name="dimensions[shape]" value="cylinder">

            <div class="mb-4 input-group inline align-items-center">
                <label for="dimensions.height">{{ __('Height (cm)') }}</label>
                <input class="input" type="number" min="1" id="dimensions.height" name="dimensions[height]" value="{{ old('dimensions.height') }}" placeholder="e.g. 1">
                @if ($errors->has('dimensions.height'))
                    <div class="input--error">{{ $errors->first('dimensions.height') }}</div>
                @endif
            </div>

            <div class="mb-7 input-group inline align-items-center">
                <label for="dimensions.diameter">{{ __('Diameter (cm)') }}</label>
                <input class="input" type="number" min="1" id="dimensions.diameter" name="dimensions[diameter]" value="{{ old('dimensions.diameter') }}" placeholder="e.g. 1">
                @if ($errors->has('dimensions.diameter'))
                    <div class="input--error">{{ $errors->first('dimensions.diameter') }}</div>
                @endif
            </div>

            <h3>Household</h3>
            <div class="mb-4 input-group inline align-items-center">
                <label for="place">{{ __('Address') }}</label>
                <input class="input" type="text" id="place" name="place" value="{{ old('place') }}" placeholder="e.g. 12 Kagan Ave, Mangawhai">
                <output for="place" name="address">{
                    name: '12 kagan ave',
                    city: 'mangawhai',
                    country: 'new zealand',
                    latlng: {
                        lat: 'asdasd',
                        lng: 'asdasd',
                    }
                }</output>
                @if ($errors->has('place'))
                    <div class="input--error">{{ $errors->first('place') }}</div>
                @endif
            </div>

            <div class="mb-7 input-group inline align-items-center">
                <label for="household_size">{{ __('Size') }}</label>
                <input class="input" type="number" min="1" id="household_size" name="household_size" value="{{ old('household_size') }}" placeholder="# of Residents">
                @if ($errors->has('household_size'))
                    <div class="input--error">{{ $errors->first('household_size') }}</div>
                @endif
            </div>

            @if ($errors->count())
                <div class="input--error">{{ $errors->first() }}</div>
            @endif

            <button type="submit" class="button">Register Device</button>
        </form>
    </div>

    <svg id="progress" class="block mx-auto w-auto" width="300px" height="22px" viewBox="0 0 300 22">
        <defs>
            <circle id="oval" r="10" cy="11"></circle>
        </defs>

        <g stroke="#3FA9F5" stroke-width="2">
            <path id="line" d="M0,11 L300,11" stroke-linecap="square"></path>

            <use href="#oval" fill="#B3DDFA" x="11"></use>
            <use href="#oval" fill="#FFFFFF" x="82"></use>
            <use href="#oval" fill="#FFFFFF" x="152"></use>
            <use href="#oval" fill="#FFFFFF" x="222"></use>
            <use href="#oval" fill="#FFFFFF" x="289"></use>
        </g>
    </svg>
@endsection
