<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Public API Routes
 */

$router->post('devices/{device}/token', [
    'uses' => Api\Device\TokenController::class.'@store',
    'as' => 'api',
    'middleware' => ['device.firmware']
]);


/**
 * User authenticated API routes
 * using the user's API token
 */
$router->group(['middleware' => [
    'auth:api',
]], function ($router) {
    $router->apiResource('devices', Api\Device\DeviceController::class, [
        'as' => 'api',
    ]);

    /* Web Push Notifications */
    $router->post('push-service', [
        'uses' => Api\PushServiceController::class.'@store',
        'as' => 'api.notifications.subscribe'
    ]);

    $router->delete('push-service/{subscription}', [
        'uses' => Api\PushServiceController::class.'@delete',
        'as' => 'api.notifications.unsubscribe'
    ]);

    // Get the autheneticated user
    $router->get('auth/user', [
        'uses' => Api\AuthUserController::class.'@show',
        'as' => 'api.auth.user.show',
    ]);
});


/**
 * Devide API routes
 * routes where the device hardware is the client,
 * which has its own API token to authenticate.
 */
$router->group(['middleware' => [
    'auth:device',
    'device.firmware',
]], function ($router) {
    $router->post('devices/{device}/ping', [
        'uses' => Api\Device\PingController::class.'@store',
        'as' => 'api.devices.ping',
    ]);

    $router->apiResource('devices/{device}/metrics', Api\Device\MetricController::class, [
        'only' => ['store'],
    ]);
});
