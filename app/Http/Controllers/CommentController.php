<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function storeComment(StoreCommentRequest $request, Post $post)
    {
         $newComment = Comment::create([
             'post_id' => $post->id,
             'user_id' => Auth::id(),
             'comment' => $request->validated()['comment'],
         ]);
 
         return response()->json([
             'success' => true,
             'message' => 'You have succesfully added the comment to the blog!',
             'data' => $newComment,
         ], 201);
    }

     public function deleteComment(Comment $comment)
    {
 
         $userId = Auth::id();
 
         if(!$userId){
             return response()->json(['error' => 'Unauthorized'], 403);
 
         }
 
         $isCommentOwner = $userId === $comment->user_id;
         $isPostOwner = $userId === $comment->post->user_id;
 
         if($isCommentOwner || $isPostOwner){
             $comment->delete();
             return response()->json(['message'=> 'Comment deleted succesfully!']);
         }
 
         return response()->json(['error' => 'You do not have permission to delete this comment'], 403);
     
    }

    public function index()
    {
        //
    }

    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   
}
