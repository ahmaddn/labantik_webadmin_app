<?php

use App\Http\Controllers\auth\AuthenticationUserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ExtrakulikulerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\UploadController;
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
    // legacy generic upload endpoint (calls UploadController::upload)
    Route::post('/upload-image', [UploadController::class, 'upload'])->name('upload.image');
    // news-specific upload endpoint used by the editor
    Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('news.upload.image');
    Route::resource('news', NewsController::class);
    Route::resource('extrakulikuler', ExtrakulikulerController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('visionmissions', VisionMissionController::class);
    Route::resource('profiles', ProfileController::class);
});
