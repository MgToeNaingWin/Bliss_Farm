<?php

return [

    'default' => env('BROADCAST_CONNECTION', 'log'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER', 'ap1'),
                'useTLS' => true,
            ],
            'client_options' => [
                'curl_options' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                ],
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

    ],

    'channels' => [
        'presence-*' => [
            'driver' => 'pusher',
        ],
        'private-*' => [
            'driver' => 'pusher',
        ],
    ],

];
