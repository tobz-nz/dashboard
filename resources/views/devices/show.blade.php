@extends('layouts.app')

@section('title', 'Trends')

@section('content')

    <header class="content-header">
        <h1>Trends</h1>
    </header>

    <svg class="block my-8 mx-auto" width="80%" height="200" viewBox="0 0 1240 250" preserveAspectRatio="xMinYMid meet" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient x1="50%" y1="50%" x2="50%" y2="124.454%" id="a">
                <stop stop-color="#3FA9F5" offset="0%"/>
                <stop stop-color="#C82F2F" offset="100%"/>
            </linearGradient>
        </defs>
        <g fill="none" fill-rule="evenodd">
            <path d="M2 110c10 0 30 20 47 30 14 6 41-31 50-30 18 4 134 79 175 79 18 0 99-105 108-108 18 0 45 7 67 13 32 16 50 41 63 41 14 0 36-35 72-70 20-20 29-39 40-39 17 0 27 39 41 39 22 0 49-56 76-56 55 0 236 72 288 82 18 3 36-26 49-26 18 0 50 34 72 34 23-11 72-82 91-82" transform="translate(.718 21.184)" stroke="url(#a)" stroke-width="4"/>
            <text font-family="Barlow-Medium, Barlow" font-size="28" font-weight="400" fill="#9A9A9A" transform="translate(0 -2)">
                <tspan x="13.718" y="28.851">100%</tspan>
            </text>
            <text font-family="Barlow-Medium, Barlow" font-size="28" font-weight="400" fill="#9A9A9A" transform="translate(0 -2)">
                <tspan x="13.718" y="236.5">0%</tspan>
            </text>
            <path d="M1.764 249.992V-1.309" stroke="#979797" stroke-linecap="square" stroke-dasharray="10"/>
            <path d="M1241.833 249.75L.838 248.535" stroke="#9A9A9A" stroke-linecap="square" stroke-dasharray="10"/>
            <path d="M1241.833 169.632L.838 170.75" stroke="#E64141" opacity=".699" stroke-linecap="square" stroke-dasharray="10"/>
            <path d="M1241.833 71.38L.838 70.25" stroke="#72D64F" stroke-linecap="square" stroke-dasharray="10"/>
        </g>
    </svg>


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
