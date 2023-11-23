<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Posts
    Route::get('/posts', [PostController::class, 'index']); // All posts
    Route::post('/posts', [PostController::class, 'store']); // Create post
    Route::get('/posts/{id}', [PostController::class, 'show']); // Get single post
    Route::put('/posts/{id}', [PostController::class, 'update']); // Update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // Delete post

    // Comments
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // All comments
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // Create a comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // Update comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // Delete comment

    // Likes
    Route::get('/posts/{id}/likes', [LikeController::class, 'likeOrDislike']); // Like or dislike a post

});
