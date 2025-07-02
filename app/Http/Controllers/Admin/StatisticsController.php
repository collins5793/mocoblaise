<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\UserProgress;
use App\Models\UserQuizAttempt;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        // Utilisateurs
        $totalUsers = User::count();
        $activeUsers =$totalUsers;

        // Cours
        $totalCourses = Course::count();

        // Leçons
        $totalLessons = Lesson::count();

        // Quiz
        $totalQuizzes = Quiz::count();

        // Certificats
        $totalCertificates = Certificate::count();

        // Moyenne score quiz (global)
        $averageScore = UserQuizAttempt::avg('score') ?? 0;

        // Taux de réussite (>= 70%)
        $passedCount = UserQuizAttempt::where('passed', true)->count();
        $totalAttempts = UserQuizAttempt::count();
        $passRate = $totalAttempts > 0 ? round(($passedCount / $totalAttempts) * 100, 2) : 0;

        // Cours les plus populaires (nb inscrits) - supposons table pivot user_course
        $popularCourses = DB::table('user_courses')
            ->select('course_id', DB::raw('count(user_id) as count'))
            ->groupBy('course_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Préparer noms et valeurs
        $popularCoursesNames = Course::whereIn('id', $popularCourses->pluck('course_id'))->pluck('title', 'id');
        $popularCoursesLabels = [];
        $popularCoursesData = [];

        foreach ($popularCourses as $c) {
            $popularCoursesLabels[] = $popularCoursesNames[$c->course_id] ?? 'Cours #' . $c->course_id;
            $popularCoursesData[] = $c->count;
        }

        return view('admin.statistics.index', compact(
            'totalUsers', 'activeUsers', 'totalCourses', 'totalLessons', 'totalQuizzes', 'totalCertificates',
            'averageScore', 'passRate', 'popularCoursesLabels', 'popularCoursesData'
        ));
    }
}
