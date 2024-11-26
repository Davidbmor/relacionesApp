<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('post.index');
// Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
Route::resource('post', PostController::class);
Route::post('post/{post}/comment',[PostController::class, 'storeComment'])->name('post.comment');
Route::resource('comment', CommentController::class);
