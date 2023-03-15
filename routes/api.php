<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

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

Route::get('/categories/{category:slug}/posts',[CategoryController::class,'categoryPost']);
Route::get('/search_posts/{query}',[PostController::class,'searchPosts']);
Route::apiResource('/posts',PostController::class);
Route::apiResource('/categories',CategoryController::class);
Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);

Route::middleware('auth:api')->group(function () {

    Route::get('user', [UserController::class,'details']);
    Route::post('comment/create', [CommentController::class,'store']);
    Route::get('unread-notifications', [UserController::class,'getUnreadNotifications']);
    Route::get('notifications', [UserController::class,'getAllNotifications']);
    Route::post('markNotificationAsRead', [UserController::class,'markNotificationAsRead']);
});
Route::prefix("/admin")->middleware('auth:api')->group(function () {
    Route::get('posts', [AdminController::class,'getPosts']);
    Route::post('posts/add', [AdminController::class,'addPost']);
    Route::post('posts/update', [AdminController::class,'updatePost']);
    Route::get('categories', [AdminController::class,'getCategories']);
    Route::post('posts/delete', [AdminController::class,'deletePosts']);
    Route::post('post/delete', [AdminController::class,'deletePost']);
});

