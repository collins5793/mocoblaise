<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\UserQuizAttempt;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Cours suivis
        $courses = $user->courses ?? []; // si relation courses existe

        // Tentatives de quiz
        $quizAttempts = UserQuizAttempt::where('user_id', $user->id)->get();

        // Moyenne
        $averageScore = $quizAttempts->avg('score') ?? 0;

        // Liste des cours terminés (où tous les leçons et quiz sont faits)
        $completedCourses = [];
        $inProgressCourses = [];

        foreach ($courses as $course) {
            $lessons = $course->lessons;
            $totalLessons = $lessons->count();
            $viewedLessons = $lessons->filter(fn($lesson) => $lesson->isViewedBy($user))->count();
            $quizDone = $lessons->filter(fn($lesson) => $lesson->quiz && $lesson->quiz->isPassedBy($user))->count();
            $progress = 0;

            $totalElements = $totalLessons + $lessons->filter(fn($l) => $l->quiz)->count();
            $doneElements = $viewedLessons + $quizDone;

            if ($totalElements > 0) {
                $progress = ($doneElements / $totalElements) * 100;
            }

            if ($progress == 100) {
                $completedCourses[] = [
                    'course' => $course,
                    'progress' => $progress
                ];
            } else {
                $inProgressCourses[] = [
                    'course' => $course,
                    'progress' => $progress
                ];
            }
        }

        return view('dashboard.user', [
            'user' => $user,
            'averageScore' => $averageScore,
            'quizAttempts' => $quizAttempts,
            'completedCourses' => $completedCourses,
            'inProgressCourses' => $inProgressCourses,
        ]);
    }
}
