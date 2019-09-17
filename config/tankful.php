<?php

return [
    'website' => [
        'domain' => env('WEBSITE_DOMAIN', 'tankful.nz')
    ],

    'firmware' => [
        'domain' => env('FIRMWARE_DOMAIN', 'updates.tankful.nz')
    ],

    'support' => [
        'email' => [
            'address' => env('SUPPORT_EMAIL', 'support@tankful.nz'),
        ]
    ]
];
