<?php

// Just used for the webServiceURL during setup
$router->any('apns', [
    'uses' => Push\APNS\TokenController::class.'@index',
    'as' => 'apns'
]);

// Safari push package ZIP file
$router->post('apns/{version}/pushPackages/{websitePushID}', [
    'uses' => Push\APNS\PushPackageController::class.'@show',
    'as' => 'apns.pushpackage'
]);

// register the device token
$router->post('apns/{version}/devices/{deviceToken}/registrations/{websitePushID}', [
    'uses' => Push\APNS\TokenController::class.'@store',
    'as' => 'apns.store'
]);

// de-register the device token
$router->delete('apns/{version}/devices/{deviceToken}/registrations/{websitePushID}', [
    'uses' => Push\APNS\TokenController::class.'@destroy',
    'as' => 'apns.destroy'
]);

// Safari pushes errors here (why not just in the console though ffs?)
$router->post('apns/{version}/log', [
    'uses' => Push\APNS\LogController::class.'@store',
    'as' => 'apns.log'
]);
