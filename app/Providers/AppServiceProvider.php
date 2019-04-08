<?php

namespace App\Providers;

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
        $this->registerBladeExtensions();
        $this->registerMacros();
        $this->registerViewComposers();
    }

    private function registerBladeExtensions()
    {
        Blade::component('components.input');
        Blade::component('components.checkable');
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
            $devices = $user->devices;
            $device = $devices->first();

            $view->with(compact('user', 'device', 'devices'));
        });
    }
}
