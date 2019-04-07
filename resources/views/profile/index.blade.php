@extends('layouts.app')

@section('title', 'Account')

@section('nav-links')
    @include('account.nav-links')
@endsection

@section('content')
    <header class="content-header">
        <h1>User Account</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">
        <form class="w-full" action="{{ route('profile.update', $user) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('patch') }}

            @input([
                'id' => 'name',
                'name' => 'name',
                'value' => old('name', $user->name),
                'class' => 'mb-4 inline',
            ])This is your name. @endinput

            @input([
                'id' => 'email',
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email Address',
                'value' => old('email', $user->email),
                'class' => 'mb-4 inline',
            ])This is your email address. @endinput

            <h2>Preferences:</h2>

            <div class="flex justify-between">
                <button type="submit" class="mb-7 button">Update Profile</button>
                {{-- <button form="close-account-form" type="submit" class="mb-7 button--link danger" onclick="return confirm('Are you REALLY Sure?')">Close Account</button> --}}
            </div>

        </form>
    </div>
@endsection
