@extends('layouts.app', compact('device'))

@section('title', 'Trends')

@section('nav-links')
    @include('devices.nav-links')
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <script src="https://leaverou.github.io/conic-gradient/conic-gradient.js"></script>
@endpush

@section('content')

    <header class="content-header">
        <h1>{{ $device->name }}: Trends</h1>
        <div class="text-right text-2">Updated <time class="nowrap" datetime="{{ $device->getDate('last_seen_at')->format(DateTime::ATOM) }}">{{ $device->getDate('last_seen_at')->calendar() }}</time></div>
    </header>

    @if ($device->meta->is_missing??null === true)
    @alert(['status' => 'error', 'class' => 'm-4'])
        @slot('title', __('Connection Lost'))

        <div>{!! __('We have not received any information from this Unit since <time>:datetime</time>!', ['datetime' => $device->last_seen_at->format('Y-m-d H:ia')]) !!}</div>
        <div>{!! __('<a href=":url"><strong>We\'re here to help</strong></a>', ['url'=>route('website.faqs')]) !!}</div>
    @endalert
    @endif

    <div class="grid grid-minmax mx-auto pt-6 justify-center gap-3" style="--min:300px">

        <div class="pie mx-auto" style="--value: {{ $device->currentPercent * .01 }}">
            <div class="text-8">{{ $device->currentPercent }}%</div>
            <div>{{ round($device->currentLevel / 10) }} cm</div>
            <div>{{ $device->currentVolume }} L</div>

            <div class="pie-fallback" style="background-image: radial-gradient(white calc(var(--size) * 0.42), transparent 0%), conic-gradient(from 120deg, transparent 33%, var({{ $device->levelColor }}) 33%, var({{ $device->levelColor }}) {{ 33 + (67 * $device->currentPercent * .01)}}%, var(--blue-5) {{ 33 + (67 * $device->currentPercent * .01)}}%, var(--blue-5) 360deg);"></div>
        </div>

        <div class="grid justify-center align-items-center">
            <div class="days-remaining flex flex-col justify-center align-items-center rounded-full" style="--size: 210px; width: var(--size); height:var(--size); box-shadow:0 0 10px var({{ $device->daysRemaining > 7 ? '--blue-0' : '--red-0' }})">
                <span class="days-remaining__counter block text-center" style="font-size: var(--text-10);">{{ (int) $device->daysRemaining ?? 'Indeterminate' }}</span>
                <span>Days remaining</span>
                <small class="text-light">avg {{ $device->mmToLitres($device->burnRate) }}L per day</small>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <?php
        $data = $device->dailyMetrics($limit = 30)->orderByDesc('max_created_at')->get()->transform(function($metric) use ($device) {
            $percent = round($metric->value / data_get($device->dimensions, 'height', 0) * 100);

            return (object) [
                'name' => $metric->created_at->format('Y-m-d'),
                'value' => [$metric->created_at->format('Y-m-d'), $percent],
                'depth' => round($metric->value / 10),
                'percent' => $percent,
                'meta' => $metric->meta ?: [],
                'volume' => $device->mmToLitres($metric->value),
            ];
        })
        ?>
        <tf-chart title="Test Chart" :max="100" :data='@json($data)'></tf-chart>
    </div>

    <div class="mb-8 px-4 overflow-auto">
        <iframe id="forecast_embed" frameborder="0" height="245" width="100%" src="//forecast.io/embed/#color=#33aaff&font=Barlow&lat={{ $device->address->latlng->lat }}&lon={{ $device->address->latlng->lng }}&name={{ $device->address->city }}&units=ca"></iframe>
    </div>

@endsection
