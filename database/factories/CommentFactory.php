<?php

namespace database\factories;

use Faker\Generator as Faker;

class CommentFactory
{
    public static function getFactory(Faker $faker)
    {
        return [
            'ip' => $faker->randomNumber(),
            'comment' => $faker->text(500),
            'movie_id' => $faker->ean8(7),
        ];
        
    }
}
