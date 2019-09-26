<?php

use JoyBusinessAcademy\Profile\Models\Profile;

$regions = \JoyBusinessAcademy\Profile\Models\Region::whereNotNull('parent_id')->pluck('id')->toArray();

$genders = [
    Profile::GENDER_FEMALE,
    Profile::GENDER_MALE,
    Profile::GENDER_OTHER,
];

$factory->define(Profile::class, function(\Faker\Generator $faker) use ($regions, $genders){
    return [
        'id' => random_int(1, 1000),
        'first_name' => \Illuminate\Support\Str::random(10),
        'last_name' => \Illuminate\Support\Str::random(10),
        'phone' => $faker->phoneNumber,
        'gender' => \Illuminate\Support\Arr::random($genders),
        'avatar' => '',
        'location' => $faker->streetAddress,
        'date_of_birth' => $faker->date('Y-m-d', now()->subYears(16)),
        'ethnicity' => '',
        'residency' => '',
        'employment_status' => $faker->boolean,
        'region_id' => \Illuminate\Support\Arr::random($regions)
    ];
});