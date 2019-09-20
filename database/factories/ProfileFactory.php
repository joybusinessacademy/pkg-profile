<?php

use JoyBusinessAcademy\Profile\Models\Profile;

include (__DIR__ . '/../seeds/RegionSeeder.php');

$regionSeeder = new RegionSeeder();
$regionSeeder->run();

$regions = \JoyBusinessAcademy\Profile\Models\Region::whereNotNull('parent_id')->pluck('id')->toArray();

$genders = [
    Profile::GENDER_FEMALE,
    Profile::GENDER_MALE,
    Profile::GENDER_OTHER,
];

$factory->define(Profile::class, function(\Faker\Generator $faker) use ($regions, $genders){
    return [
        'id' => random_int(1, 1000),
        'user_id' => random_int(1, 2000),
        'first_name' => \Illuminate\Support\Str::random(10),
        'last_name' => \Illuminate\Support\Str::random(10),
        'phone' => $faker->phoneNumber,
        'gender' => \Illuminate\Support\Arr::random($genders),
        'avatar' => '',
        'location' => $faker->streetAddress,
        'date_of_birth' => $faker->dateTimeThisCentury(),
        'ethnicity' => '',
        'residency' => '',
        'employment_status' => $faker->boolean,
        'region_id' => \Illuminate\Support\Arr::random($regions)
    ];
});