<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryManageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostManageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [PostManageController::class, 'index'])->name('index');
    Route::get('/posts/create', [PostManageController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostManageController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostManageController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostManageController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostManageController::class, 'destroy'])->name('posts.destroy');
    Route::get('/categories', [CategoryManageController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryManageController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryManageController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryManageController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryManageController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryManageController::class, 'destroy'])->name('categories.destroy');
});
