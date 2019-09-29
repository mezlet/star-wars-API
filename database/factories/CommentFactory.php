<?php

namespace database\factories;

use Faker\Generator as Faker;

class CommentFactory
{
    public static function getFactory(Faker $faker)
    {
        return [
            'ip' => $faker->randomNumber(),
            'details' => $faker->text(500),
            'movie_id' => $faker->randomNumber(),
        ];
        
    }
}
