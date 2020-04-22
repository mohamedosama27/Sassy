<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\image;
use App\item;
use Faker\Generator as Faker;

$factory->define(image::class, function (Faker $faker) {
    $image=image::all()->random(1);
    $item=item::all()->random(1);

    return [
        'name'=>$image[0]->name,
        'item_id' => $item[0]->id,

    ];
});
