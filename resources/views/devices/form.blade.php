@csrf()

<div class="mb-4 input-group inline @if($errors->has('name'))input--invalid @endif">
    <label class="input-label" for="name">{{ __('Name') }}</label>
    <input class="input-field" type="text" id="name" name="name" value="{{ old('name', $device->name) }}" placeholder="e.g. Main Water Tank" @if($errors->has('name'))aria-errormessage="error-message-name" aria-invalid @endif autofocus>
    @if ($errors->has('name'))
        <div id="error-message-name" class="input--error">{{ $errors->first('name') }}</div>
    @endif
    <div class="input-summary">This field is just so you can manage multiple Tanks/properties easier.</div>
</div>

<div class="mb-7 input-group inline @if($errors->has('color'))input--invalid @endif">
    <label class="input-label" for="color">{{ __('Colour') }}</label>
    <input class="input-field" type="color" id="color" name="color" value="{{ old('color', $device->color ?: '#33aaff') }}" placeholder="e.g. Main Water Tank">
    @if ($errors->has('color'))
        <div class="input--error">{{ $errors->first('color') }}</div>
    @endif
    <div class="input-summary">This field is also mainly for help managing more Tanks/properties.</div>
</div>

<h3 class="mt-0 mb-2">Dimensions</h3>
<input type="hidden" name="dimensions[shape]" value="cylinder">

<div class="mb-4 input-group inline @if($errors->has('dimensions.diameter'))input--invalid @endif">
    <label class="input-label" for="dimensions.diameter">{{ __('Diameter (cm)') }}</label>
    <input class="input-field" type="number" min="1" id="dimensions.diameter" name="dimensions[diameter]" value="{{ old('dimensions.diameter', $device->dimensions->diameter??null) }}" placeholder="e.g. 350" @if($errors->has('dimensions.diameter'))aria-errormessage="error-message-dimensions.diameter" aria-invalid @endif required>
    @if ($errors->has('dimensions.diameter'))
        <div id="error-message-dimensions.diameter" class="input--error">{{ $errors->first('dimensions.diameter') }}</div>
    @endif
    <div class="input-summary">This field is the diameter of your water tank - the measurement across the top from one side to the other. Typically this is 350cm (3.5 meters).</div>
</div>

<div class="mb-4 input-group inline @if($errors->has('dimensions.height'))input--invalid @endif">
    <label class="input-label" for="dimensions.height">{{ __('Height (cm)') }}</label>
    <input class="input-field" type="number" min="1" id="dimensions.height" name="dimensions[height]" value="{{ old('dimensions.height', $device->dimensions->height??null) }}" placeholder="e.g. 25000" required>
    @if ($errors->has('dimensions.height'))
        <div class="input--error">{{ $errors->first('dimensions.height') }}</div>
    @endif
    <div class="input-summary">This field is the maximum height of the tank. I.E. The highest depth of water.</div>
</div>

<div class="mb-7 input-group inline @if($errors->has('dimensions.catchment'))input--invalid @endif">
    <label class="input-label" for="meta.catchment">{{ __('Catchment Area') }} (M<sup>2</sup>)</label>
    <input class="input-field" type="number" min="1" id="meta.catchment" name="meta[catchment]" value="{{ old('meta.catchment', $device->meta->catchment??null) }}" placeholder="e.g. 145">
    @if ($errors->has('meta.catchment'))
        <div class="input--error">{{ $errors->first('meta.catchment') }}</div>
    @endif
    <div class="input-summary">The Catchment Area is generally the total roof space of your house - this is used to help calculate how much rain you should be catching.</div>
</div>

<h3 class="mt-0 mb-2">Household</h3>
<div class="mb-4 input-group inline @if($errors->has('dimensions.address'))input--invalid @endif">
    <label class="input-label" for="place">{{ __('Address') }}</label>
    <places-field class="input-field" id="place" name="place" data-field="address-location" value="{{ old('place', optional($device->address)->name ?? null) }}" placeholder="e.g. 12 Kagan Ave, Mangawhai" data-place required></places-field>

    <div class="input-summary">The address field is used to look up weather forecasts and to book deliveries &amp; other servies.</div>

    <input type="hidden" id="address-name" name="address[name]" value="{{ old('address.name', optional($device->address)->name ?? '') }}">
    <input type="hidden" id="address-city" name="address[city]" value="{{ old('address.city', optional($device->address)->city ?? '') }}">
    <input type="hidden" id="address-country" name="address[country]" value="{{ old('address.country', optional($device->address)->country ?? '') }}">
    <input type="hidden" id="address-postcode" name="address[postcode]" value="{{ old('address.postcode', optional($device->address)->postcode ?? '') }}">
    <input type="hidden" id="address-latlng-lat" name="address[latlng][lat]" value="{{ old('address.latlng.lat', optional($device->address)->latlng->lat ?? '') }}">
    <input type="hidden" id="address-latlng-lng" name="address[latlng][lng]" value="{{ old('address.latlng.lng', optional($device->address)->latlng->lng ?? '') }}">

    @if ($errors->has('address') || $errors->has('place'))
        <div class="input--error">{{ $errors->first('place') ?: $errors->first('address') }}</div>
    @endif

</div>

<div class="mb-2 input-group @if($errors->has('household_type'))input--invalid @endif">
    <label class="input-label" for="household_type_residential">{{ __('Type of property') }}</label>
    <div class="flex flex-col py-1 input-field-group">

        <label for="household_type_residential" class="input-label input-group--checkable mb-2">
            <input class="input--checkable" type="radio" name="address[household_type]" id="household_type_residential" {{ old('address.household_type', optional($device->address)->household_type) == 'residential' ? 'checked' : '' }} value="residential">
            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="{{ asset('images/icons.svg#radio') }}"></use>
                <use class="checked" xlink:href="{{ asset('images/icons.svg#radio_checked') }}"></use>
            </svg>
            {{ __('Residential') }}
        </label>

        <label for="household_type_holiday" class="input-label input-group--checkable mb-2">
            <input class="input--checkable" type="radio" name="address[household_type]" id="household_type_holiday" {{ old('address.household_type', optional($device->address)->household_type) == 'holiday' ? 'checked' : '' }} value="holiday">
            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="{{ asset('images/icons.svg#radio') }}"></use>
                <use class="checked" xlink:href="{{ asset('images/icons.svg#radio_checked') }}"></use>
            </svg>
            {{ __('Holiday Home / Batch') }}
        </label>

        <label for="household_type_lifestyle" class="input-label input-group--checkable mb-2">
            <input class="input--checkable" type="radio" name="address[household_type]" id="household_type_lifestyle" {{ old('address.household_type', optional($device->address)->household_type) == 'lifestyle' ? 'checked' : '' }} value="lifestyle">
            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="{{ asset('images/icons.svg#radio') }}"></use>
                <use class="checked" xlink:href="{{ asset('images/icons.svg#radio_checked') }}"></use>
            </svg>
            {{ __('Lifestyle Block') }}
        </label>

        <label for="household_type_commercial" class="input-label input-group--checkable mb-2">
            <input class="input--checkable" type="radio" name="address[household_type]" id="household_type_commercial" {{ old('address.household_type', optional($device->address)->household_type) == 'commercial' ? 'checked' : '' }} value="commercial">
            <svg class="input--checkbox"  width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="{{ asset('images/icons.svg#radio') }}"></use>
                <use class="checked" xlink:href="{{ asset('images/icons.svg#radio_checked') }}"></use>
            </svg>
            {{ __('Commercial') }}
        </label>
    </div>
    @if ($errors->has('household_type'))
        <div class="input--error">{{ $errors->first('household_type') }}</div>
    @endif
    <div class="input-summary">The property type is used to help us categorize and calculate how much water you use.</div>
</div>

<div class="mb-7 input-group inline @if($errors->has('household_size'))input--invalid @endif">
    <label class="input-label" for="household_size">{{ __('Number of Residents') }}</label>
    <input class="input-field" type="number" min="1" id="household_size" name="household_size" value="{{ old('household_size', $device->household_size) }}" placeholder="# of Residents" required>
    @if ($errors->has('household_size'))
        <div class="input--error">{{ $errors->first('household_size') }}</div>
    @endif
    <div class="input-summary">The household size is the number of people living at the address. We use this information to help calculate how much water you use on a daily basis.</div>
</div>


@push('scripts', '<script src="https://cdn.jsdelivr.net/npm/places.js@1.16.4"></script>')
