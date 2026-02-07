<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listAllPosts()
    {
        $data = Post::all();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Posts not found'
            ], 404);
        }

        return response()->json($data);

    }

    public function showAPostWithAllComments($id)
    {
        $post = Post::with('comments')->find($id);

        if(!$post){
            return response()->json(['message' => 'Post not found'],404);
        }

        return response()->json($post);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeAPost(StorePostRequest $request)
    {

        $user = Auth::user();//visszatér a bej user obj
        if(!$user){
            return response()->json(['message' => 'Did you forget to login?'], 401);
        }

        $newPost = Post::create([
            'user_id' => $user->id,
            'title' => $request->validated()['title'],
            'content' => $request->validated()['content']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You have succesfully added the post to the blog!',
            'data' => $newPost,
        ], 201);
    }

    /**
     * Display the specified resource.
     */


    public function editThePost(Post $post)//urlben lévő ID alapján megkeresi a konkrét post-ot, és obj-t kapunk
    {
        $userId = Auth::id();

        if(!$userId){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $postOwner = $post->user_id;

        if ($userId !== $postOwner) {
            return response()->json([
                'message' => 'You have no access for this process.'
            ], 403);
        }
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePost(StorePostRequest $request, Post $post)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $postId = $post->user_id;

        if($userId === $postId){
            $post->update($request->validated());
    
            return response()->json([
                'message' => 'Post updated!',
                'post' => $post
            ]);

        }

        return response()->json(['message' => 'You cannot edit this post!'], 403);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePost(Post $post)
    {
       
        $userId = Auth::id();

        if(!$userId){
            return response()->json(['error' => 'Unauthorized'], 403);

        }

        $postOwner = $post->user_id;

        if($postOwner === $userId){
            $post->delete();
            return response()->json(['message' => 'Post deleted successfully!']);

        }
        return response()->json(['error' => 'You do not have permission to delete this post'], 403);



        
    }
}
