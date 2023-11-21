<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; // Corrected the namespace

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
//public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    //user
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    //posts
    Routes::get('/posts', [PostController::class, 'index']); //all posts
    Routes::post('/posts/{id}', [PostController::class, 'store']); //create post
    Routes::get('/posts/{id}', [PostController::class, 'show']); //get single post
    Routes::put('/posts/{id}', [PostController::class, 'update']); //update post
    Routes::delete('/posts/{id}', [PostController::class, 'destroy']); //delete post

    //comments
    Routes::get('/posts/{id}/comments', [PostController::class, 'index']); //all comments
    Routes::post('/posts/{id}/comments', [PostController::class, 'store']); //create a comment on apost
    Routes::put('/comments{id}', [PostController::class, 'update']); //update comment
    Routes::delete('/comments{id}', [PostController::class, 'destroy']); //delete comment

    //Likes
    Routes::get('/posts/{id}/likes', [PostController::class, 'likeordislike']); //like or dislike back post

});
