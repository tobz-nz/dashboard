@extends('layouts.app')

@section('title', 'Trends')

@section('nav-links')
    @include('devices.nav-links')
@endsection

@section('content')

    <header class="content-header">
        <h1>Trends</h1>
    </header>

    @if ($device->meta->is_missing??null === true)
    @alert(['status' => 'error', 'class' => 'm-4'])
        @slot('title', __('Connection Lost'))

        <div>{!! __('We have not received any information from this Unit since <time>:datetime</time>!', ['datetime' => $device->last_seen_at->format('Y-m-d H:ia')]) !!}</div>
        <div>{!! __('<a href=":url"><strong>We\'re here to help</strong></a>', ['url'=>route('website.faqs')]) !!}</div>
    @endalert
    @endif

    <div class="grid grid-flow-col mx-auto justify-around">
        <div class="current-status grid">
            <tf-pie :value="{{ $device->currentPercent }}" style="color:hsl(205, 100%, 60%)"></tf-pie>
            <div class="status-details">
                <div>{{ $device->currentLevel }} cm</div>
                <div>{{ $device->currentVolume }} L<sup>3</sup></div>
            </div>
        </div>
    </div>

    <div>
        <?php
        $data = $device->dailyMetrics($limit = 30)->get()->transform(function($metric) use ($device) {
            return (object) [
                'name' => $metric->created_at->format('Y-m-d'),
                'value' => [$metric->created_at->format('Y-m-d'), round($metric->value / data_get($device->dimensions, 'height', 0) * 100, 2)],
            ];
        })
        ?>
        <tf-chart title="Test Chart" :max="100" :data='@json($data)'></tf-chart>
    </div>

@endsection
