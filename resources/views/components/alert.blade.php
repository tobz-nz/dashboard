<section class="alert alert--{{ $status ?? 'info' }} {{ $class ?? '' }}" role="alert">
    <div>
        @isset ($title)
            <h1 class="mb-3 text-5">{{ $title }}</h1>
        @endisset

        {{ $slot }}
    </div>
</section>
