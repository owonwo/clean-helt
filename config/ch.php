<?php

return [
    'chcode_prefixes' => [
        'CHD' => 'App\Models\Doctor',
        'CHH' => 'App\Models\Hospital',
        'CHP' => 'App\Models\Patient',
        'CHL' => 'App\Models\Laboratory',
        'CHF' => 'App\Models\Pharmacy'
    ],

    'auth' => [
        'grant_type' => getenv('AUTH_GRANT_TYPE'),
        'client_id' => getenv('AUTH_CLIENT_ID'),
        'client_secret' => getenv('AUTH_CLIENT_SECRET')
    ],
];