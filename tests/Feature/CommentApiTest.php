<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_post_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $payload = [
            'comment' => 'This is a long enough content for the test.'
        ];

        $response = $this->actingAs($user)->postJson("/api/post/comment/{$post->id}", $payload);

        if ($response->status() !== 201) {
            dump($response->json()); 
        }
            $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'comment' => 'This is a long enough content for the test.',
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }
}
