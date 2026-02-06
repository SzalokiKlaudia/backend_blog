<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => DB::table('posts')->inRandomOrder()->value('id'),
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'comment' => fake()->sentence(12),
        ];
    }
}
