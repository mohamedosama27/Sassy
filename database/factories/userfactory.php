<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\image;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $password= bcrypt('12345678');
    return [
        'name' => 'sassy',
        'email' => 'dmin@gmail.com',
        'phone' => '01118221684',
        'email_verified_at' => now(),
        'password' => $password, // password
        'remember_token' => Str::random(10),
    ];
});
