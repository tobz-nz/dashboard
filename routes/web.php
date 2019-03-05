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

$router->view('styleguide', 'styleguide');

$router->group(['middleware' => 'verified'], function($router) {
    $router->get('/', [
        'uses' => DashboardController::class . '@index',
        'as' => 'dashboard',
        'middleware' => 'device.check',
    ]);

    $router->resource('setup', SetupController::class, [
        'only' => ['index', 'store'],
    ]);

    $router->resource('devices', DeviceController::class);

    $router->get('account', [
        'uses' => AccountController::class . '@index',
        'as' => 'account',
    ]);
});
