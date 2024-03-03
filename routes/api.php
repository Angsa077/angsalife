<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('check-auth', [LoginController::class, 'checkAuth'])->name('checkAuth');

Route::get('profile', [UsersController::class, 'profile'])->name('profile');
Route::resource('users', UsersController::class);
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagsController::class);
Route::resource('posts', PostsController::class);
Route::resource('comments', CommentsController::class);