<?php

use App\Http\Controllers\auth\AuthenticationUserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthenticationUserController::class, 'login'])->name('login');
Route::post('/login', [AuthenticationUserController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthenticationUserController::class, 'authenticate'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('news', NewsController::class);
    Route::resource('categories', CategoriesController::class);
});
