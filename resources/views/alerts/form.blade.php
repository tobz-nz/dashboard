<form class="pt-3 px-3" action="{{ $route }}" method="POST">
    @method($alert->exists ? 'put' : 'POST')
    @csrf()

    <div class="grid gap-2 grid-flow-col input-group items-center" style="grid-template-columns: 1fr 4fr 1fr">
        <label class="input-label" for="percent-{{ $alert->id ?? 0 }}">{{ __('Alert me when level') }}</label>

        <div class="grid gap-2" style="grid-template-columns: 2fr 1fr;">
            <select name="trigger" id="alert-trigger-{{ $alert->id ?? 0 }}" class="form-control">
                <option value="1"@if(old('trigger', $alert->trigger) == 1)selected @endif>Drops to</option>
                <option value="2"@if(old('trigger', $alert->trigger) == 2)selected @endif>Raises to</option>
                <option value="3"@if(old('trigger', $alert->trigger) == 3)selected @endif>Changes to</option>
            </select>

            <div class="grid grid-flow-col">
                <input id="percent-{{ $alert->id ?? 0 }}" type="number" class="form-control" name="percent" min="0" max="100" value="{{ old('percent', $alert->percent) }}" min="0" max="100" placeholder="e.g. 50%" required>
                <div class="input-group-append">
                    <div class="input-group-text" title="Percent">%</div>
                </div>
            </div>
        </div>

        <button class="button" type="submit">{{ $alert->exists ? 'Update' : 'Add' }}</button>
        @if ($alert->exists)
        <button class="button--link" style="color: var(--red-1)" type="submit" form="delete-{{ $alert->id ?? 0 }}">
            <svg width="20" height="20">
                <title>Remove</title>
                <use xlink:href="{{ asset('images/icons.svg#trash') }}"></use>
            </svg>
        </button>
        @else
        <div class="p-5" style="width:25px"></div>
        @endif
    </div>
</form>

@push('extras')
    @if ($alert->exists)
        <form id="delete-{{ $alert->id ?? 0 }}" action="{{ route('alerts.destroy', compact('device', 'alert')) }}" method="POST">
            @method('DELETE')
            @csrf()
        </form>
    @endif
@endpush
