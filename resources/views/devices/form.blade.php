@csrf()

<div class="mb-4 input-group inline @if($errors->has('name'))input--invalid @endif">
    <label class="input-label" for="name">{{ __('Name') }}</label>
    <input class="input-field" type="text" id="name" name="name" value="{{ old('name', $device->name) }}" placeholder="e.g. Main Water Tank" autofocus>
    <div class="input-summary">This field is just so you can manage multiple Tanks/properties easier.</div>
    @if ($errors->has('name'))
        <div class="input--error">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="mb-7 input-group inline @if($errors->has('color'))input--invalid @endif">
    <label class="input-label" for="color">{{ __('Colour') }}</label>
    <input class="input-field" type="color" id="color" name="color" value="{{ old('color', $device->color ?: '#33aaff') }}" placeholder="e.g. Main Water Tank">
    <div class="input-summary">This field is also mainly for help managing more Tanks/properties.</div>
    @if ($errors->has('color'))
        <div class="input--error">{{ $errors->first('color') }}</div>
    @endif
</div>

<h3 class="mt-0 mb-2">Dimensions</h3>
<input type="hidden" name="dimensions[shape]" value="cylinder">

<div class="mb-4 input-group inline @if($errors->has('dimensions.diameter'))input--invalid @endif">
    <label class="input-label" for="dimensions.diameter">{{ __('Diameter (cm)') }}</label>
    <input class="input-field" type="number" min="1" id="dimensions.diameter" name="dimensions[diameter]" value="{{ old('dimensions.diameter', $device->dimensions->diameter??null) }}" placeholder="e.g. 350" required>
    <div class="input-summary">This field is the diameter of your water tank - the measurement across the top from one side to the other. Typically this is 350cm (3.5 meters).</div>
    @if ($errors->has('dimensions.diameter'))
        <div class="input--error">{{ $errors->first('dimensions.diameter') }}</div>
    @endif
</div>

<div class="mb-4 input-group inline @if($errors->has('dimensions.height'))input--invalid @endif">
    <label class="input-label" for="dimensions.height">{{ __('Height (cm)') }}</label>
    <input class="input-field" type="number" min="1" id="dimensions.height" name="dimensions[height]" value="{{ old('dimensions.height', $device->dimensions->height??null) }}" placeholder="e.g. 25000" required>
    <div class="input-summary">This field is the maximum height of the tank. I.E. The highest depth of water.</div>
    @if ($errors->has('dimensions.height'))
        <div class="input--error">{{ $errors->first('dimensions.height') }}</div>
    @endif
</div>

<div class="mb-7 input-group inline @if($errors->has('dimensions.catchment'))input--invalid @endif">
    <label class="input-label" for="meta.catchment">{{ __('Catchment Area') }} (M<sup>2</sup>)</label>
    <input class="input-field" type="number" min="1" id="meta.catchment" name="meta[catchment]" value="{{ old('meta.catchment', $device->meta->catchment??null) }}" placeholder="e.g. 145">
    <div class="input-summary">The Catchment Area is generally the total roof space of your house - this is used to help calculate how much rain you should be catching.</div>
    @if ($errors->has('meta.catchment'))
        <div class="input--error">{{ $errors->first('meta.catchment') }}</div>
    @endif
</div>

<h3 class="mt-0 mb-2">Household</h3>
<div class="mb-4 input-group inline @if($errors->has('dimensions.address'))input--invalid @endif">
    <label class="input-label" for="place">{{ __('Address') }}</label>
    <input class="input-field" type="text" id="place" name="place" value="{{ old('place', optional($device->address)->name) }}" placeholder="e.g. 12 Kagan Ave, Mangawhai" data-place required>
    <div class="input-summary">The address field is used to look up weather forecasts and to book deliveries &amp; other servies.</div>

    <input type="hidden" name="address[name]" value="{{ optional($device->address)->name ?? '' }}">
    <input type="hidden" name="address[city]" value="{{ optional($device->address)->city ?? '' }}">
    <input type="hidden" name="address[country]" value="{{ optional($device->address)->country ?? '' }}">
    <input type="hidden" name="address[latlng][lat]" value="{{ optional($device->address)->latlng->lat ?? '' }}">
    <input type="hidden" name="address[latlng][lng]" value="{{ optional($device->address)->latlng->lng ?? '' }}">

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
    <div class="input-summary">The property type is used to help us categorize and calculate how much water you use.</div>
    @if ($errors->has('household_type'))
        <div class="input--error">{{ $errors->first('household_type') }}</div>
    @endif
</div>

<div class="mb-7 input-group inline @if($errors->has('household_size'))input--invalid @endif">
    <label class="input-label" for="household_size">{{ __('Number of Residents') }}</label>
    <input class="input-field" type="number" min="1" id="household_size" name="household_size" value="{{ old('household_size', $device->household_size) }}" placeholder="# of Residents" required>
    <div class="input-summary">The household size is the number of people living at the address. We use this information to help calculate how much water you use on a daily basis.</div>
    @if ($errors->has('household_size'))
        <div class="input--error">{{ $errors->first('household_size') }}</div>
    @endif
</div>
