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

        'region' => \JoyBusinessAcademy\Profile\Models\Region::class,

        'experience' => \JoyBusinessAcademy\Profile\Models\Experience::class,

        'education' => \JoyBusinessAcademy\Profile\Models\Education::class,

        'reference' => \JoyBusinessAcademy\Profile\Models\Reference::class,

        'resume' => \JoyBusinessAcademy\Profile\Models\Resume::class
    ],

    'table_names' => [

        /*
         * We need to know which table should be used to retrieve your profiles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */
        'profiles' => 'profiles',

        'users' => 'users',

        'regions' => 'regions',

        'experiences' => 'experiences',

        'educations' => 'educations',

        'references' => 'references',

        'resumes' => 'resumes',
    ],

    'repositories' => [

        'profile' => \JoyBusinessAcademy\Profile\Repositories\ProfileRepository::class,

        'region' => \JoyBusinessAcademy\Profile\Repositories\RegionRepository::class,

        'experience' => \JoyBusinessAcademy\Profile\Repositories\ExperienceRepository::class,

        'education' => \JoyBusinessAcademy\Profile\Repositories\EducationRepository::class,

        'reference' => \JoyBusinessAcademy\Profile\Repositories\ReferenceRepository::class,

        'resume' => \JoyBusinessAcademy\Profile\Repositories\ResumeRepository::class,
        
    ],

    'attributes' => [

        'resume' => [
            'multiple' => env('PROFILE_RESUME_MULTIPLE', false),
            'maximum' => env('PROFILE_RESUME_MAXIMUM', 5),
            'max_size' => env('PROFILE_RESUME_MAX_SIZE', 20000),
            'mime_types' => env('PROFILE_RESUME_MIME_TYPES', 'pdf,doc,txt')
        ],

        'profile' => [
            'auto_create' => [
                'name' => ''
            ]
        ],

        'cover_letter' => [
            'max_size' => env('PROFILE_COVER_LETTER_MAX_SIZE', 10000),
            'mime_types' => env('PROFILE_COVER_LETTER_MIME_TYPES', 'pdf,doc,txt')
        ]
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

        'store' => 'default'
    ],

    'storage' => [
        's3' => [
            'credentials' => [
                'key'    => env('AWS_KEY', ''),
                'secret' => env('AWS_SECRET', ''),
            ],
            'region' => env('AWS_REGION', 'us-east-1'),
            'version' => 'latest',
            'ua_append' => [
                'L5MOD/' . \Aws\Laravel\AwsServiceProvider::VERSION,
            ],
            'bucket' => env('AWS_BUCKET', '')
        ]
    ],

    'route' => [
        'prefix' => 'jba-profile',
        'middleware' => ['auth'],
        'namespace' => 'JoyBusinessAcademy\Profile\Controllers',
        'prefix_name' => 'jba-profile.'
    ]

];