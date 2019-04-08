<div class="input-group {{ $class??'' }} @if($errors->has($name))input--invalid @endif">
    <label class="input-label" for="{{ $id??$name }}">{{ __($label??ucfirst($name)) }}</label>
    <input class="input-field" type="{{ $type??'text' }}" id="{{ $id??$name }}" name="{{ $name }}" value="{{ old($name, $value??null) }}" placeholder="{{ $placeholder??'' }}" @if($errors->has($name))aria-errormessage="error-message-{{ $id??$name }}" aria-invalid @endif {{ $attributes??'' }}>
    @if ($errors->has($name))
        <div id="error-message-{{ $id??$name }}" class="input--error">{{ $errors->first($name) }}</div>
    @endif
    @isset($slot)<div class="input-summary">{{ $slot }}</div> @endisset
</div>
