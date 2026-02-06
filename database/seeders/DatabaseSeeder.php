<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(4)->create();

        Post::factory(10)
        ->make()
        ->each(function (Post $post): void {
            $post->user_id = User::inRandomOrder()->value('id');
            $post->save();
        });

        Comment::factory(50)
            ->make()
            ->each(function (Comment $comment): void {
                $comment->post_id = Post::inRandomOrder()->value('id');
                $comment->user_id = User::inRandomOrder()->value('id');
                $comment->save();
            });
    }
}
