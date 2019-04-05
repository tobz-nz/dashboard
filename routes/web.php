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

$router->redirect('/', 'login');

$router->view('offline', 'offline');
$router->get('manifest.webmanifest', [
    'uses' => ManifestController::class.'@show',
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
]], function($router) {
    $router->get('/', [
        'uses' => DashboardController::class . '@index',
        'as' => 'dashboard',
        'middleware' => ['device.check'],
    ]);

    $router->resource('setup', SetupController::class, [
        'only' => ['index', 'store'],
    ]);

    $router->resource('devices', DeviceController::class);
    $router->resource('devices/{device}/alerts', AlertController::class);

    $router->resource('account', AccountController::class, [
        'only' => ['index', 'edit', 'update']
    ]);
});

$router->view('styleguide', 'styleguide');
