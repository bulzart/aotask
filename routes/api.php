<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/posts',[PostController::class,'listAllPosts']);
Route::get('/posts/{id}',[PostController::class,'listPost']);
Route::get('posts/{id}/comments',[PostController::class,'listAllPostComments']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/posts',[PostController::class,'createPost']);
Route::post('/posts/{id}/comments',[PostController::class,'addComment']);
Route::delete('/posts/{id}',[PostController::class,'deletePost'])->middleware('verifyPostOwner');
Route::put('/posts/{id}',[PostController::class,'editPostWithId'])->middleware('verifyPostOwner');
});

