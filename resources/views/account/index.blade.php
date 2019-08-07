@extends('layouts.app')

@section('title', 'Subscription')

@section('nav-links')
    @include('account.nav-links')
@endsection

@section('content')
    <header class="content-header">
        <h1>@yield('title')</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">

        @foreach([(object)['name' => 'Free Plan', 'price' => 0, 'features' => ['Free'], 'conditions' => 'Per Month']] as $plan)
            <div class="plan">
                <header>
                    {{ $plan->name }}
                    <div class="plan__cost">
                        <span class="plan__price">{{ money_format('$%.2n', $plan->price) }}</span>
                        <span class="plan__conditions">{{ $plan->conditions }}</span>
                    </div>
                    <ul class="plan__features">
                        @foreach ($plan->features as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <button type="submit">Current PLan</button>
                </header>
            </div>
        @endforeach

    </div>
@endsection
