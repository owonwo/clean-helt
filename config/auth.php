<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],

        'hospital' => [
            'driver' => 'session',
            'provider' => 'hospitals'
        ],

        'hospital-api' => [
            'driver' => 'passport',
            'provider' => 'hospitals',
        ],

        'doctor' => [
            'driver' => 'session',
            'provider' => 'doctors'
        ],

        'doctor-api' => [
            'driver' => 'passport',
            'provider' => 'doctors',
        ],

        'pharmacy' => [
            'driver' => 'session',
            'provider' => 'pharmacies'
        ],

        'pharmacy-api' => [
            'driver' => 'passport',
            'provider' => 'pharmacies',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins'
        ],

        'admin-api' => [
            'driver' => 'passport',
            'provider' => 'admins',
        ],

        'laboratory' => [
            'driver' => 'session',
            'provider' => 'laboratories'
        ],

        'laboratory-api' => [
            'driver' => 'passport',
            'provider' => 'laboratories',
        ],
        'patient' => [
            'driver' => 'session',
            'provider' => 'patients'
        ],

        'patient-api' => [
            'driver' => 'passport',
            'provider' => 'patients',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'hospitals' => [
            'driver' => 'eloquent',
            'model' => App\Models\Hospital::class,
        ],

        'doctors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doctor::class,
        ],

        'pharmacies' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pharmacy::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'laboratories' => [
            'driver' => 'eloquent',
            'model' => App\Models\Laboratory::class,
        ],
        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'hospitals' => [
            'provider' => 'hospitals',
            'table' => 'password_resets',
            'expire' =>  60,
        ],
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'pharmacies' => [
            'provider' => 'pharmacies',
            'table' => 'password_resets',
            'expire' => 60
        ],
        'doctors' => [
            'provider' => 'doctors',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'laboratories' => [
            'provider' => 'laboratories',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'patients' => [
            'provider' => 'patients',
            'table' => 'password_resets',
            'expire' => 60,
        ]
    ],

];
