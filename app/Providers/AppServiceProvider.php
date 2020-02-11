<?php

namespace App\Providers;

use App\Device;
use App\Observers\DeviceObserver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModelObservers();
        $this->registerBladeExtensions();
        $this->registerMacros();
        $this->registerViewComposers();
    }

    private function registerModelObservers()
    {
        Device::observe(DeviceObserver::class);
    }

    private function registerBladeExtensions()
    {
        Blade::component('components.input');
        Blade::component('components.checkable');
        Blade::component('components.alert');
    }

    private function registerMacros()
    {
        Arr::macro('html_attributes', function (array $attributes): string {
            $attrs = [];
            foreach ($attributes as $key => $value) {
                if (is_bool($value)) {
                    $attrs[] = $key;
                    continue;
                }

                $attrs[] = sprintf('%s="%s"', $key, $value);
            }

            return implode(' ', $attrs);
        });
    }

    private function registerViewComposers()
    {
        View::composer('layouts.app', function ($view) {
            $user = auth()->user();
            $devices = app('cache')->rememberForever($user->getCachKey('devices'), function () use ($user) {
                return $user->devices()->orderBy('created_at')->paginate();
            });
            // $device = $devices->first();

            $view->with(compact('user', 'devices'));
        });
    }
}
