<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});
Route::get('/users', [UserController::class, 'index'])->middleware('auth:api');

// create posts
// get all posts
// get single post
// get your posts
Route::get('/posts', [PostController::class, 'all']);
Route::get('/posts/{id}', [PostController::class, 'find']);
Route::post('/posts', [PostController::class, 'create'])->middleware('auth:api');
Route::put('/posts/{id}', [PostController::class, 'update'])->middleware('auth:api');
Route::delete('/posts/{id}', [PostController::class, 'delete'])->middleware('auth:api');
Route::get('/post/{id}/likers', [PostController::class, 'likers']);
Route::get('/post/{id}/likes', [PostController::class, 'likes']);

Route::get('/post/{id}', [PostController::class, 'comments']);
Route::post('/post/comment', [CommentController::class, 'create'])->middleware('auth:api');
Route::put('/post/comment/{id}', [CommentController::class, 'edit'])->middleware('auth:api');
Route::delete('/post/comment/{id}', [CommentController::class, 'delete'])->middleware('auth:api');

Route::get('/user/{id}', [UserController::class, 'show']);

Route::post('/post/{id}/like', [LikeController::class, 'like'])->middleware('auth:api');
Route::post('/post/{id}/unlike', [LikeController::class, 'unlike'])->middleware('auth:api');

// these route names do not follow a standard, i should fix that
// group prefixes
// group middleware routes