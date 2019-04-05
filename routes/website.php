<?php

$router->get('/', [
    'uses' => WebsiteController::class.'@placeholder',
    'as' => 'website.index',
]);

$router->get('faqs', [
    'uses' => WebsiteController::class.'@placeholder',
    'as' => 'website.faqs',
]);
