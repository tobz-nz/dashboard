<div class="input-group input-group--checkable {{ $class??'' }} @if($errors->has($name))input--invalid @endif">
    <input class="input-field" type="{{ $type??'checkbox' }}" id="{{ $id??$name }}" name="{{ $name }}" {{ old($name, $checked??false) ? ' checked' : '' }} value="{{ $value ?? true }}" placeholder="{{ $placeholder??'' }}" @if($errors->has($name))aria-errormessage="error-message-{{ $id??$name }}" aria-invalid @endif {{ $attributes??'' }}>
    <label class="input-label" for="{{ $id??$name }}">{{ __($label??ucfirst($name)) }}</label>
    @if ($errors->has($name))
        <div id="error-message-{{ $id??$name }}" class="input--error">{{ $errors->first($name) }}</div>
    @endif
    @isset($slot)<div class="input-summary">{{ $slot }}</div> @endisset
</div>
