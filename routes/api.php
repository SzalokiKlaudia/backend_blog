<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/posts', [PostController::class, 'listAllPosts']);
Route::get('/posts/{id}', [PostController::class, 'showAPostWithAllComments']);
Route::post('post/{post}/comment', [CommentController::class, 'storeComment']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/user/post', [PostController::class, 'storeAPost']);
    Route::get('/user/post/{post}/edit', [PostController::class, 'editThePost']);
    Route::put('/user/post/{post}', [PostController::class, 'updatePost']);
    Route::delete('/user/post/{post}', [PostController::class, 'deletePost']);
    
    Route::delete('/user/comments/{comment}', [CommentController::class, 'deleteComment']);

});

