<?php

return [

    'gateway' => \JoyBusinessAcademy\Profile\ProfileGateway::class,

    'models' => [

        /*
         * We need to know which Eloquent model should be used to retrieve your profiles. Of course, it
         * is often just the "Profile" model but you may use whatever you like.
         *
         * The model you want to use as a Profile model needs to implement the
         * `JoyBusinessAcademy\Profile\Models\Profile` contract.
         */
        'profile' => \JoyBusinessAcademy\Profile\Models\Profile::class,

        'user' => \JoyBusinessAcademy\Profile\Models\User::class,

        'region' => \JoyBusinessAcademy\Profile\Models\Region::class
    ],

    'table_names' => [

        /*
         * We need to know which table should be used to retrieve your profiles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */
        'profiles' => 'profiles',

        'users' => 'users',

        'regions' => 'regions'
    ],

    'repositories' => [

        'profile' => \JoyBusinessAcademy\Profile\Repositories\ProfileRepository::class,

        'region' => \JoyBusinessAcademy\Profile\Repositories\RegionRepository::class
    ],

    'cache' => [

        /*
         * By default all profiles are cached for 24 hours to speed up performance.
         * When profiles are updated the cache is flushed automatically.
         */
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => '_jba-profile_',

        'model_key' => 'id',

        'store' => 'default'
    ]
];