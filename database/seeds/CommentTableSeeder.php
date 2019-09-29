<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Comment::class, 1)->create();
        // You can add more seeds here
        $faker = \Faker\Factory::create();

        Comment::create([
            'ip' => '35676',
            'details' => 'we are here now',
            'movie_id' => 3456
        ]);

        
    }
}
