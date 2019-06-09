<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'article_id' => factory('App\Models\Article')->create()->id,
        'user_id' => factory('App\Models\User')->create()->id,
        'comment' => $faker->realText,
    ];
});
