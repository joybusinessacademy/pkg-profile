<?php

return [

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

    'handlers' => [

     //   'profile' => \JoyBusinessAcademy\Profile\Repositories\ProfileRepository::class,

    //        'region' => \JoyBusinessAcademy\Profile\Repositories\RegionRepository::class
    ],

    'cache' => [


    ]
];