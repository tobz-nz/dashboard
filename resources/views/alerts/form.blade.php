<form class="grid mb-3 pt-3 px-3 w-full" style="grid-template-columns: max-content min-content auto" action="{{ $route }}" method="POST">
    @method($alert->exists ? 'put' : 'POST')
    @csrf()

    <div class="grid subgrid gap input-group items-center" style="grid-template-rows: auto auto; --gap:var(--gap-2) var(--gap-3)">
        <label class="input-label grid-span-cols" for="percent-{{ $alert->id ?? 0 }}">{{ __('Alert me when water level') }}</label>

        <select name="trigger" id="alert-trigger-{{ $alert->id ?? 0 }}" class="input-field">
            <option value="1"@if(old('trigger', $alert->trigger) == 1)selected @endif>Drops to</option>
            <option value="2"@if(old('trigger', $alert->trigger) == 2)selected @endif>Raises to</option>
            <option value="3"@if(old('trigger', $alert->trigger) == 3)selected @endif>Passes</option>
        </select>

        <div class="relative grid grid-flow-col gap-2 items-center">
            <input id="percent-{{ $alert->id ?? 0 }}" type="number" class="input-field" name="percent" min="0" max="100" value="{{ old('percent', $alert->percent) }}" min="0" max="100" placeholder="e.g. 50%" required>
            <div class="absolute input-group-append opaque" style="right: 35px; --opacity: 0.6">
                <div class="input-group-text" title="Percent">%</div>
            </div>
        </div>

        <div class="flex justify-start">
            <button class="" type="submit">
                <svg width="20" height="20">
                    @if ($alert->exists)
                        <title>Update</title>
                        <use xlink:href="{{ asset('images/icons.svg#tick') }}"></use>
                    @else
                        <title>Add</title>
                        <use xlink:href="{{ asset('images/icons.svg#add') }}"></use>
                    @endif
                </svg>
            </button>

            @if ($alert->exists)
                <button class="button--link" style="color: var(--red-1)" type="submit" form="delete-{{ $alert->id ?? 0 }}">
                    <svg width="20" height="20">
                        <title>Remove</title>
                        <use xlink:href="{{ asset('images/icons.svg#trash') }}"></use>
                    </svg>
                </button>
            @else
                {{-- <div class="p-5" style="width:25px"></div> --}}
            @endif
        </div>
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
