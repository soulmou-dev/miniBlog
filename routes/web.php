<?php

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