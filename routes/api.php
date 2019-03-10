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

$router->group(['middleware' => [
    'auth:api',
]], function($router) {
    /* Web Push Notifications */
    $router->post('push-service', [
        'uses' => Api\PushServiceController::class.'@store',
        'as' => 'api.notifications.subscribe'
    ]);

    $router->delete('push-service/{subscription}', [
        'uses' => Api\PushServiceController::class.'@delete',
        'as' => 'api.notifications.unsubscribe'
    ]);
});
