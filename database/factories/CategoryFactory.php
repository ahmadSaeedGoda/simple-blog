<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $str_name = $faker->unique()->sentence;
    return [
        'name' => $str_name,
        'slug' => Str::slug($str_name),
    ];
});
