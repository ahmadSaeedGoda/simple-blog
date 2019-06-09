<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $str_title = $faker->unique()->sentence;
    return [
        'category_id' => factory('App\Models\Category')->create()->id,
        'title' => $str_title,
        'slug' => Str::slug($str_title),
        'body' => $faker->realText,
    ];
});
