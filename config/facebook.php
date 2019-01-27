<?php

return [

    'credentials' => [
        //'app_id' => '198813647125028',
        //'app_secret' => '3782624ed73745e3aaf2dd794aed4ff5',
        'app_id' => env('FACEBOOK_CLIENT_ID'),
        'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'default_graph_version' => env('DEFAULT_GRAPH_VERSION'),
    ]
];
