<?php

$factory->define(\JoyBusinessAcademy\Profile\Models\User::class, function(\Faker\Generator $faker) {

    return [
        'name' => \Illuminate\Support\Str::random(10),
        'email' => $faker->email,
        'password' => \Illuminate\Support\Facades\Hash::make($faker->password)
    ];
});