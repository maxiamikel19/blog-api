<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthController::class,'logout']);

    Route::apiResource('posts',PostController::class);
    Route::get('/user/posts', [PostController::class,'getUserPosts']);

    Route::apiResource('/comments', CommentController::class);

    Route::get('/users/{id}', [UserController::class,'show']);
});


Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

