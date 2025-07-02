<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatisticsController;

// ==========================
// 🌐 PUBLIC ROUTES
// ==========================
Route::get('/', fn() => view('welcome'));

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/auth/redirect/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/callback/google', [GoogleController::class, 'callback'])->name('google.callback');

// ==========================
// 👤 AUTH & PROFILE
// ==========================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/mon-dashboard', [UserDashboardController::class, 'index'])->name('dashboard.user');
});

// ==========================
// 🧑‍🎓 USER COURSES
// ==========================
Route::get('/cours', [CourseController::class, 'all'])->name('courses.all');
Route::get('/cours/categorie/{category}', [CourseController::class, 'byCategory'])->name('courses.byCategory');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::post('/courses/{course}/comment', [CommentController::class, 'store'])->name('courses.comment.store');
Route::post('/courses/{course}/complete', [CourseController::class, 'markAsCompleted'])->name('courses.complete');

// ==========================
// 📚 LESSONS (USER)
// ==========================
Route::get('/courses/{course}/start', [LessonController::class, 'start'])->name('courses.start');
Route::get('/courses/{course}/lesson/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
Route::post('/lessons/{lesson}/complete', [LessonController::class, 'markAsCompleted'])->name('lessons.complete');

// ==========================
// 🧠 QUIZZES (USER)
// ==========================
Route::get('/lessons/{lesson}/quiz', [QuizController::class, 'start'])->name('quizzes.start');
Route::get('/quizzes/start/{lesson}', [QuizController::class, 'start']);
Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'showByQuiz'])->name('quizzes.questions');

// ==========================
// 📜 CERTIFICATES
// ==========================
Route::get('/certificates/download/{course}', [CertificateController::class, 'download'])->name('certificates.download');
Route::middleware('auth')->group(function () {
    Route::get('/courses/{course}/certificate', [CertificateController::class, 'generate'])->name('certificates.generate');
});
Route::get('/certificates/generate/{course}', [CertificateController::class, 'generate'])->name('certificates.generate');

// ==========================
// 🛠️ ADMIN AUTH
// ==========================
Route::get('/admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

// ==========================
// 🧑‍💼 ADMIN DASHBOARD
// ==========================
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ici tu peux ajouter d'autres routes admin (users, courses, etc.)
});


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
});
Route::get('/admin/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/admin/certificates', [CertificateController::class, 'index'])->name('admin.certificates.index');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('settings', 'admin.settings.index')->name('settings.index');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('certificates/generate/{courseId}', [CertificateController::class, 'generate'])->name('certificates.generate');
       Route::get('certificates/export-csv', [CertificateController::class, 'exportCsv'])->name('certificates.exportCsv');

    Route::get('certificates/download/{courseId}', [CertificateController::class, 'download'])->name('certificates.download');
});


    Route::resource('courses', CourseController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('quizzes', QuizController::class);
Route::get('/courses/export', [CourseController::class, 'exportCsv'])->name('courses.exportCsv');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::get('admin/lessons', [LessonController::class, 'all'])->name('lessons.all');
    Route::get('lessons/{lesson}/quizzes', [QuizController::class, 'listByLesson'])->name('quizzes.byLesson');
    Route::get('lessons/{lesson}/quizzes/create', [QuizController::class, 'createForLesson'])->name('quizzes.createForLesson');
    Route::post('lessons/{lesson}/quizzes', [QuizController::class, 'storeForLesson'])->name('quizzes.storeForLesson');
});

// Redondance (gardée)
Route::get('admin/lessons/{lesson}/quizzes/create', [QuizController::class, 'createForLesson'])->name('quizzes.createForLesson');
Route::get('admin/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::get('admin/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('admin/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('admin/lessons/create', [LessonController::class, 'create'])->name('lessons.create');

// ==========================
// 📦 RESOURCES
// ==========================
Route::middleware('auth')->group(function () {
    Route::resource('courses', CourseController::class);
});
Route::resource('quizzes', QuizController::class);

// ==========================
// ❓ QUESTIONS / ANSWERS
// ==========================
Route::prefix('quizzes/{quiz}')->group(function () {
    Route::resource('questions', QuestionController::class);
});

Route::prefix('questions/{question}')->group(function () {
    Route::resource('answers', AnswerController::class);
});

Route::get('/questions/create/{quiz}', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/store/{quiz}', [QuestionController::class, 'store'])->name('questions.store');

Route::get('/answers/create/{quiz}', [AnswerController::class, 'create'])->name('answers.create');
Route::post('/answers/store', [AnswerController::class, 'store'])->name('answers.store');

// ==========================
// 🧪 LESSONS CREATION (direct)
// ==========================
Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
Route::post('/lessons/store', [LessonController::class, 'store'])->name('lessons.store');

// ==========================
// 🔐 AUTH FILE
// ==========================
require __DIR__.'/auth.php';
