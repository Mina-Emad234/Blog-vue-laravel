<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\categoryController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories/{category}/posts',[categoryController::class,'categoryPost']);
Route::get('/search_posts/{query}',[PostController::class,'searchPosts']);
Route::apiResource('/posts',PostController::class);
Route::apiResource('/categories',categoryController::class);
Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [UserController::class,'detaiis']);
    Route::post('comment/create', [CommentController::class,'store']);
});
Route::prefix("/admin")->middleware('auth:api')->group(function () {
    Route::get('posts', [AdminController::class,'getPosts']);
    Route::post('posts/add', [AdminController::class,'addPost']);
    Route::post('posts/update', [AdminController::class,'updatePost']);
    Route::get('categories', [AdminController::class,'getCategories']);
    Route::get('posts/delete', [AdminController::class,'deletePosts']);
});