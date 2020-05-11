<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Lab::class, function (Faker $faker) {

    // //create random lat/long within a certain radius (credit: https://stackoverflow.com/questions/5460838/php-select-a-random-lon-lat-within-a-certain-radius)
    // $longitude = (float) -79.347015;
    // $latitude = (float) 43.6510702;
    // $radius = rand(1, 100); // in miles

    // $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
    // $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
    // $lat_min = $latitude - ($radius / 69);
    // $lat_max = $latitude + ($radius / 69);

    return [
        'name' => $faker->text(50),
        'lat' => '',
        'long' => '',
    ];
});
