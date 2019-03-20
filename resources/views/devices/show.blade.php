@extends('layouts.app')

@section('title', 'Trends')

@section('content')

    <header class="content-header">
        <h1>Trends</h1>
    </header>

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

    <div class="grid grid-flow-col mx-auto justify-around">
        <div class="grid">
            <span>{{ $device->currentLevel }} cm</span>
            <meter min="0" max="{{ $device->dimensions->height }}" value="{{ $device->currentLevel }}"></meter>
        </div>
        <div class="grid">
            <span>{{ $device->currentPercent }}%</span>
            <meter min="0" low="30" high="70" max="100" optimum="100" value="{{ $device->currentPercent }}"></meter>
        </div>
        <div class="grid">
            <span>{{ $device->currentVolume }} L<sup>3</sup></span>
            <meter dir="vertical" min="0" max="{{ $device->maxVolume }}" value="{{ $device->currentVolume }}"></meter>
        </div>
    </div>

@endsection
