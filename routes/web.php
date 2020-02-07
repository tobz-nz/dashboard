<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes(['verify' => true]);
Route::impersonate();

$router->redirect('/', 'login');

$router->view('offline', 'offline');
$router->get('manifest.webmanifest', [
    'uses' => ManifestController::class . '@show',
    'as' => 'webmanifest',
]);

/**
 * Public/unauthenticated routes for APN push notifications.
 */
include 'push/apns.php';

/**
 * Authenticated Routes
 */
$router->group(['middleware' => [
    'auth',
    'verified',
    'service.worker',
]], function ($router) {
    $router->get('/', [
        'uses' => DashboardController::class . '@index',
        'as' => 'dashboard',
        'middleware' => ['device.check'],
    ]);

    $router->resource('setup', SetupController::class, [
        'only' => ['index', 'store'],
    ]);

    $router->resource('users', UserController::class);
    $router->resource('devices', DeviceController::class);
    $router->resource('devices/{device}/alerts', AlertController::class);

    $router->resource('account/profile', ProfileController::class, [
        'only' => ['index', 'edit', 'update', 'destroy'],
        'parameters' => ['profile' => 'user'],
    ]);

    $router->resource('account/subscription', SubscriptionController::class, [
        'only' => ['index', 'update', 'destroy'],
    ]);
});

$router->group(['domain' => config('tankful.firmware.domain')], function ($router) {
    // used in firmware version caching command
    $router->redirect('/current.json', '/')->name('firmware.current');
});

$router->view('styleguide', 'styleguide');
