@extends('layouts.app')

@section('title', 'Personal Profile')

@section('nav-links')
    @include('account.nav-links')
@endsection

@section('content')
    <header class="content-header">
        <h1>@yield('title')</h1>
    </header>

    <div class="pt-7 px-8 flex flex-col items-start">
        <form class="w-full" action="{{ route('profile.update', $user) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('patch') }}

            @input([
                'id' => 'name',
                'name' => 'name',
                'label' => 'Full Name',
                'placeholder' => 'e.g. Samual Vimes',
                'value' => old('name', $user->name),
                'class' => 'mb-4 inline',
                'required' => true,
            ])We like to know our customers so we can help you to the best or our ability, real names make this a little bit easier.@endinput

            @input([
                'id' => 'email',
                'name' => 'email',
                'type' => 'email',
                'label' => 'Email Address',
                'placeholder' => '',
                'value' => old('email', $user->email),
                'class' => 'mb-4 inline',
                'required' => true,
            ])We need your email address to contact at various times - level alerts, product news. @endinput

            @input([
                'id' => 'password',
                'name' => 'password',
                'type' => 'password',
                'label' => 'Password',
                'placeholder' => 'e.g. Thisisagoodlongpassword',
                'class' => 'mb-4 inline',
            ])You need one of these so you can access your Tanful account and others cannot. @endinput

            <fieldset class="mb-5">
                <legend>Notification Preferences:</legend>

                @checkable([
                    'id' => 'email-alerts',
                    'name' => 'preferences[email_alerts]',
                    'label' => 'Enable Email Alerts',
                    'checked' => old('preferences.email_alerts', $user->preferences->email_alerts),
                    'class' => 'mb-1 inline',
                ])Do you want to receive water level alerts via email? @endcheckable

                @checkable([
                    'id' => 'push-alerts',
                    'name' => 'preferences[push_alerts]',
                    'label' => 'Enable Push Notifications',
                    'checked' => old('preferences.push_alerts', $user->preferences->push_alerts??false),
                    'class' => 'mb-1 inline',
                ])Do you want to receive water level alerts via Push Notification? @endcheckable

                @checkable([
                    'id' => 'slack-alerts',
                    'name' => 'preferences[slack_alerts]',
                    'label' => 'Enable Slack Notifications',
                    'checked' => old('preferences.slack_alerts', $user->preferences->slack_alerts??false),
                    'class' => 'mb-1 inline',
                ])Do you want to receive water level alerts via Slack? @endcheckable
            </fieldset>

            <div class="flex justify-between">
                <button type="submit" class="mb-7 button">Update Profile</button>
                {{-- <button form="close-account-form" type="submit" class="mb-7 button--link danger" onclick="return confirm('Are you REALLY Sure?')">Close Account</button> --}}
            </div>

        </form>
    </div>
@endsection
