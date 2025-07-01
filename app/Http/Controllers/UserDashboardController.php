<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use App\Models\UserProgress;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Leçons vues
        $lessonsViewed = UserProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
        $totalLessonsViewed = count($lessonsViewed);

        // Quiz tentés
        $quizAttempts = UserQuizAttempt::with('quiz.lesson')
            ->where('user_id', $user->id)
            ->get();
        $totalQuizzesDone = $quizAttempts->count();
        $averageScore = round($quizAttempts->avg('score') ?? 0, 2);

        // Cours associés à des leçons vues
        $coursesFollowed = Course::whereHas('lessons', function ($q) use ($lessonsViewed) {
            $q->whereIn('id', $lessonsViewed);
        })->with('lessons')->get();

        $totalCourses = $coursesFollowed->count();
        $courseProgress = [];
        $coursesInProgress = [];
        $completedCourses = [];

        foreach ($coursesFollowed as $course) {
    $totalLessons = $course->lessons->count();
    $lessonIds = $course->lessons->pluck('id')->toArray();

    // Quiz liés aux leçons de ce cours
    $quizCount = 0;
    foreach ($course->lessons as $lesson) {
        if ($lesson->quizzes && $lesson->quizzes->count() > 0) {
            $quizCount += $lesson->quizzes->count();
        }
    }

    $expected = $totalLessons + $quizCount;
    $lessonsViewedCount = count(array_intersect($lessonIds, $lessonsViewed));

    $quizDone = $quizAttempts->filter(function ($attempt) use ($lessonIds) {
        return $attempt->quiz && $attempt->quiz->lesson && in_array($attempt->quiz->lesson->id, $lessonIds);
    })->count();

    $done = $lessonsViewedCount + $quizDone;
    $progress = $expected > 0 ? round(($done / $expected) * 100) : 0;

    // Dernier chapitre vu
    $lastLesson = $course->lessons
        ->whereIn('id', $lessonsViewed)
        ->sortByDesc('order')
        ->first();

    $data = [
        'id' => $course->id,
        'title' => $course->title,
        'progress' => $progress,
        'last_lesson' => $lastLesson ? $lastLesson->title : 'Aucun',
        'continue_url' => route('lessons.show', [
            'course' => $course->id,
            'lesson' => $lastLesson?->id ?? $course->lessons->first()?->id
        ]),
        'certificate_url' => route('certificates.download', ['course' => $course->id]),
    ];

    // 🔍 Vérifie dans la table user_courses si terminé
    $userCourse = UserCourse::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->where('status', 'terminé')
        ->first();

    if ($userCourse) {
        $completedCourses[] = $data;
    } else {
        $coursesInProgress[] = $data;
    }

    $courseProgress[] = [
        'title' => $course->title,
        'progress' => $progress,
    ];
}

        // Notifications factices (à remplacer par les vraies plus tard)
        $notifications = [
            "🎉 Vous avez terminé une leçon récemment.",
            "📚 Un nouveau quiz est disponible dans le cours Laravel.",
            "💯 Félicitations pour votre score parfait sur le quiz PHP !"
        ];

        // Génération de certificats
        $certificates = collect($completedCourses)->map(function ($course) {
            return [
                'course_title' => $course['title'],
                'date' => now()->format('d/m/Y'),
                'download_url' => $course['certificate_url'],
            ];
        });
        // Cours terminés (avec option de générer certificat)
    $completedCourses = \App\Models\UserCourse::with('course')
        ->where('user_id', $user->id)
        ->where('status', 'terminé')
        ->get()
        ->map(function ($userCourse) {
            return [
                'id' => $userCourse->course->id,
                'title' => $userCourse->course->title,
            ];
        });

    // Certificats déjà générés
    $certificates = \App\Models\Certificate::with('course')
        ->where('user_id', $user->id)
        ->get()
        ->map(function ($cert) {
            return [
                'course_title' => $cert->course->title,
                'date' => \Carbon\Carbon::parse($cert->generated_at)->format('d/m/Y'),
                'download_url' => route('certificates.download', ['course' => $cert->course_id]),
            ];
        });

        return view('dashboard', [
            'totalCourses' => $totalCourses,
            'totalLessonsViewed' => $totalLessonsViewed,
            'totalQuizzesDone' => $totalQuizzesDone,
            'averageScore' => $averageScore,
            'courseProgress' => $courseProgress,
            'quizAttempts' => $quizAttempts,
            'coursesInProgress' => $coursesInProgress,
            'completedCourses' => $completedCourses,
            'certificates' => $certificates,
            'notifications' => $notifications,
        ]);
    }
}
