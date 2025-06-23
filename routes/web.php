<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/redirect/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/callback/google', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';


use App\Http\Controllers\CourseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class);
});
