<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    
        use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_index()
    {
        $user = User::factory()->create();
        Post::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
    }

    public function test_show_one_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->count(2)->create([
            'post_id'=> $post->id,
            'user_id' => $user->id

        ]);

        $response = $this->getJson("/api/posts/{$post->id}");
        $response->assertStatus(200)
             ->assertJsonCount(2, 'comments');

        $response->dump();

    }

    
    public function test_store_user_post()
    {
        $user = User::factory()->create();
        $payload = [
            'title' => 'My Test Title',
            'content' => 'This is a long enough content for the test.'
        ];

        $response = $this->actingAs($user)->postJson('/api/user/post', $payload);

        if ($response->status() !== 201) {
            dump($response->json()); 
        }
            $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'title' => 'My Test Title',
            'content' => 'This is a long enough content for the test.',
            'user_id' => $user->id
        ]);



    }

    public function test_it_returns_the_correct_post_data()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id, 
            'title' => 'Target Post'
        ]);

        $response = $this->actingAs($user)->getJson("/api/user/post/{$post->id}/edit");

        $response->assertStatus(200)
                ->assertJsonPath('title', 'Target Post');
    }

    public function test_authorized_user_update_post_with_valid()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original title',
            'content' => 'Original content'
        ]);

        $response = $this->actingAs($user)->putJson("/api/user/post/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content body'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content body'
        ]);
        
    }

    public function test_delete_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original title',
            'content' => 'Original content'
        ]);

        $response = $this->actingAs($user)->deleteJson("api/user/post/{$post->id}");
        $response->assertStatus(200)->assertJson(['message' => 'Post deleted successfully!']);

        $this->assertSoftDeleted('posts', [
            'id' => $post->id
        ]);

    }
}
