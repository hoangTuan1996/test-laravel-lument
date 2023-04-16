<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $post = Post::create([
                'title' => 'title ' . $i,
                'content' => 'content ' . $i,
                'description' => 'description ' . $i,
                'user_id' => User::first()->id
            ]);
        }
    }
}
