<label for="{{ $id??$name }}" class="input-group--checkable {{ $class??'' }} @if($errors->has($name))input--invalid @endif">
    <input
        class="input--checkable"
        type="{{ $type??'checkbox' }}"
        id="{{ $id??$name }}"
        name="{{ $name }}"
        value="{{ $value ?? true }}"
        placeholder="{{ $placeholder??'' }}"
        @if($errors->has($name))
        aria-errormessage="error-message-{{ $id??$name }}"
        aria-invalid
        @endif
        {{ old($name, $checked??false) ? ' checked' : '' }}
        {{ $attributes??'' }}>

    <svg class="input--checkbox" width="20" height="20">
        <use xlink:href="https://tankful.test/images/icons.svg#checkbox"></use>
        <use class="checked" xlink:href="https://tankful.test/images/icons.svg#checkbox_checked"></use>
    </svg>

    <span>{{ __($label??ucfirst($name)) }}</span>

    @if ($errors->has($name))
        <div id="error-message-{{ $id??$name }}" class="input--error">{{ $errors->first($name) }}</div>
    @endif
    @isset($slot)<div class="input-summary">{{ $slot }}</div> @endisset
</label>

{{-- <label for="remember" class="mb-6 input-group--checkable mb-4">
    <input class="input--checkable" type="checkbox" name="remember" id="remember">

    <svg class="input--checkbox" width="20" height="20" viewBox="0 0 20 20">
        <use xlink:href="https://tankful.test/images/icons.svg#checkbox"></use>
        <use class="checked" xlink:href="https://tankful.test/images/icons.svg#checkbox_checked"></use>
    </svg>

    Remember Me
</label> --}}
