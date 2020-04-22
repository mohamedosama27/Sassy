<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\item;

use Faker\Generator as Faker;

$factory->define(item::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'barcode'=>$faker->word,
        'description'=>$faker->paragraph,
        'price'=>$faker->randomDigit,
        'quantity'=>$faker->randomDigit,
        'category_id'=>$faker->randomDigit,

    ];
});
