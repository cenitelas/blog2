<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [SiteController::class, 'index'])
    ->name('index');

Route::get('about', [SiteController::class, 'about'])
    ->name('about');

Route::middleware('auth')
    ->group(function () {

        Route::resource('categories', CategoryController::class)
            ->except('index');

        Route::resource('posts', PostController::class)
            ->except('index', 'show');

        Route::put('post/{post}/like',[LikeController::class, 'toggle'])
            ->name('likes.toggle');

        Route::post('post/{post}/comment',[CommentController::class, 'store'])
            ->name('comment.create');

        Route::post('/comment/delete/{comment}',[CommentController::class, 'destroy'])
            ->name('comment.delete');
    });

Route::get('users/{user}/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::resource('posts', PostController::class)
    ->only('index', 'show');

Route::get('users/{user}/posts',[PostController::class, 'byUser'])
    ->name('user.posts');

Route::get('categories/{category}/posts',[PostController::class, 'byCategory'])
    ->name('category.posts');
