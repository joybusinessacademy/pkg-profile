<?php

use JoyBusinessAcademy\Profile\Models\Profile;

$regions = \JoyBusinessAcademy\Profile\Models\Region::whereNotNull('parent_id')->pluck('id')->toArray();


$factory->define(Profile::class, function(\Faker\Generator $faker) use ($regions){
    return [
    //    'id' => random_int(1, 1000),
        'first_name' => \Illuminate\Support\Str::random(10),
        'last_name' => \Illuminate\Support\Str::random(10),
        'phone' => $faker->phoneNumber,
        'gender' => \Illuminate\Support\Arr::random(Profile::getGenderConstants()),
        'avatar' => '',
        'location' => $faker->streetAddress,
        'date_of_birth' => $faker->date('Y-m-d', now()->subYears(16)),
        'ethnicity' => '',
        'residency' => '',
        'employment_status' => \Illuminate\Support\Arr::random(Profile::getEmploymentConstants()),
        'region_id' => \Illuminate\Support\Arr::random($regions),
        'personal_summary' => implode("\r\n", $faker->sentences(3)),
        'skills' => implode(';', $faker->words(5))
    ];
});

$factory->define(\JoyBusinessAcademy\Profile\Models\Education::class, function(\Faker\Generator $faker) {

    return [
        'school' => implode(' ', $faker->words(2)) . ' school',
        'degree' => implode(' ', $faker->words(2)) . ' degree',
        'major' => implode(' ', $faker->words(2)) . ' major',
        'start_year' => $faker->year,
        'end_year' => $faker->year,
        'grade' => implode(' ', $faker->words(1)) . ' grade',
        'activities_and_societies' => implode("\r\n", $faker->paragraphs(2)),
        'description' => implode("\r\n", $faker->paragraphs())
    ];
});

$factory->define(\JoyBusinessAcademy\Profile\Models\Experience::class, function(\Faker\Generator $faker){

    return [
        'title' => $faker->title,
        'description' => implode("\r\n", $faker->sentences(3)),
        'type' => \Illuminate\Support\Arr::random(\JoyBusinessAcademy\Profile\Models\Experience::getTypeConstants()),
        'company' => implode(' ', $faker->words(3)),
        'headline' => $faker->sentence(10),
        'location' => $faker->streetAddress,
        'current_employment' => $faker->boolean,
        'start_date' => $faker->date(),
        'end_date' => $faker->date(),
        'industry' => 'Software Development',
    ];
});

$factory->define(\JoyBusinessAcademy\Profile\Models\Reference::class, function(\Faker\Generator $faker) {

    return [
        'referrer' => $faker->name,
        'company' => implode(' ', $faker->words(3)),
        'job_title' => $faker->jobTitle,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'description' => implode("\r\n", $faker->sentences(3)),

    ];
});