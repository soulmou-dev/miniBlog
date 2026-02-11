<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// route pour la page d'acceuil
Route::get('/', function () {
    return view('welcome');
})->name('home');

//routes pour AuhController
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group( function() {
Route::get('/articles/new', [BlogController::class, 'new'])->name('articles.news');
Route::get('/articles/{id}/edit', [BlogController::class, 'edit'])->name('articles.edit');
Route::post('/articles', [BlogController::class, 'createArticle'])->name('articles.create');
Route::patch('/articles/{id}', [BlogController::class, 'updateArticle'])->name('articles.update');
Route::patch('/articles/{id}/delete', [BlogController::class, 'deleteArticle'])->name('articles.delete');
Route::patch('/articles/{id}/publish', [BlogController::class, 'publishArticle'])->name('articles.publish');
Route::patch('/articles/{id}/unpublish', [BlogController::class, 'unpublishArticle'])->name('articles.unpublish');
});

//routes pour blogController
Route::get('/', [BlogController::class, 'home'])->name('home');


Route::get('/articles/{id}', [BlogController::class, 'show'])->name('articles.show');


Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/articles', [AdminController::class, 'ArticleIndex'])
        ->name('admin.articles.index');

    Route::patch('/articles/{id}/approve', [AdminController::class, 'approveArticle'])
        ->name('admin.articles.approve');

    Route::patch('/articles/{id}/reject', [AdminController::class, 'rejectArticle'])
        ->name('admin.articles.reject');

    Route::patch('/articles/{id}/restore', [AdminController::class, 'restoreArticle'])
        ->name('admin.articles.restore');
});
