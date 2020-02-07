@extends('layouts.app')

@section('title', 'Dashboard – '.config('app.name'))

@section('content')

<ul class="devices">
    @foreach($users as $user)
    @canBeImpersonated($user)
    <li><a href="{{ route('impersonate', $user) }}">{{ $user->name }}</a></li>
    @endCanBeImpersonated
    @endforeach
</ul>

{{ $users->links() }}

@endsection
