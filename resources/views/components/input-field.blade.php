<div class="mb-4 input-group inline items-center @if($errors->has($name))input--invalid @endif">
    <label class="input-label" for="{{ $id ?? $name }}">{{ __('Name') }}</label>
    <input class="input-field" type="text" id="{{ $id ?? $name }}" name="{{ $name }}" value="{{ old($name, $value ?? null) }}" {!! \Illuminate\Support\Arr::html_attributes($attributes??[]) !!}>
    <div class="input-summary">{{ $slot }}</div>
    @if ($errors->has($name))
        <div class="input--error">{{ $errors->first($name) }}</div>
    @endif
</div>
