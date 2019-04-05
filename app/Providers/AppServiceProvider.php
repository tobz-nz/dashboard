<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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
    }

    private function registerBladeExtensions()
    {
        Blade::directive('IsRoute', function ($expression) {
            [$routeName, $returnValue] = explode('|', trim($expression, "'"));
            if (Route::is($routeName) === true) {
                return "<?php echo '{$returnValue}' ?>";
            }
        });

        Blade::component('components.input-field', 'inputField');
        Blade::component('components.alert', 'alert');
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
}
