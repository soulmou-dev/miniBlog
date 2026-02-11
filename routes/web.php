<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/**
 * routes publiques
 */

//routes pour AuhController
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login.form');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register.form');
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// routes pour UserController
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show');

//routes pour blogController
Route::get('/', [BlogController::class, 'home'])
    ->name('home');
Route::get('/articles/{id}', [BlogController::class, 'show'])
    ->name('articles.show');

/**
 * routes securisées
 */ 
Route::middleware('auth')->group( function() {
    //routes pour AuthController
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
    //routes pour UserController
    Route::get('/users/profile/edit', [UserController::class, 'edit'])
        ->name('users.profile.edit');
    Route::get('/users/profile', [UserController::class, 'myProfile'])
        ->name('users.profile');
    Route::patch('/users/profile', [UserController::class, 'updateUser'])
        ->name('users.profile.update');
   
    //routes pour BlogController
    Route::get('/articles', [BlogController::class, 'index'])
        ->name('articles.index');
    Route::get('/articles/new', [BlogController::class, 'new'])
        ->name('articles.new');
    Route::get('/articles/{id}/edit', [BlogController::class, 'edit'])
        ->name('articles.edit');
    Route::post('/articles', [BlogController::class, 'createArticle'])
        ->name('articles.create');
    Route::patch('/articles/{id}', [BlogController::class, 'updateArticle'])
        ->name('articles.update');
    Route::patch('/articles/{id}/delete', [BlogController::class, 'deleteArticle'])
        ->name('articles.delete');
    Route::patch('/articles/{id}/publish', [BlogController::class, 'publishArticle'])
        ->name('articles.publish');
    Route::patch('/articles/{id}/unpublish', [BlogController::class, 'unpublishArticle'])
        ->name('articles.unpublish');
});

/**
 * routes ADMIN
 */
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/users', [AdminController::class, 'UserIndex'])
        ->name('admin.users.index');
    Route::patch('/users/{id}/delete', [AdminController::class, 'deleteUser'])
        ->name('admin.users.delete'); 
    Route::patch('/users/{id}/restore', [AdminController::class, 'restoreUser'])
        ->name('admin.users.restore');
    Route::get('/articles', [AdminController::class, 'ArticleIndex'])
        ->name('admin.articles.index');
    Route::patch('/articles/{id}/approve', [AdminController::class, 'approveArticle'])
        ->name('admin.articles.approve');
    Route::patch('/articles/{id}/reject', [AdminController::class, 'rejectArticle'])
        ->name('admin.articles.reject');
    Route::patch('/articles/{id}/restore', [AdminController::class, 'restoreArticle'])
        ->name('admin.articles.restore');
});
