<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LessonController;

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

// Routes Quiz
Route::resource('quizzes', QuizController::class);

// Routes Question (relation avec quiz)
Route::prefix('quizzes/{quiz}')->group(function () {
    Route::resource('questions', QuestionController::class);
});

// Routes Answer (relation avec question)
Route::prefix('questions/{question}')->group(function () {
    Route::resource('answers', AnswerController::class);
});

Route::get('/questions/create/{quiz}', [\App\Http\Controllers\QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/store/{quiz}', [\App\Http\Controllers\QuestionController::class, 'store'])->name('questions.store');
Route::get('/answers/create/{quiz}', [AnswerController::class, 'create'])->name('answers.create');
Route::post('/answers/store', [AnswerController::class, 'store'])->name('answers.store');
Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
Route::post('/lessons/store', [LessonController::class, 'store'])->name('lessons.store');
Route::get('/quizzes/{quiz}/questions', [App\Http\Controllers\QuestionController::class, 'showByQuiz'])->name('quizzes.questions');

require __DIR__.'/auth.php';


use App\Http\Controllers\CourseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class);
});
