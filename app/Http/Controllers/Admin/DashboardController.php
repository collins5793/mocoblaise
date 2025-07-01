<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Certificate;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
     if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

    $totalUsers = User::count();
    $totalAdmins = User::where('role', 'admin')->count();
    $totalStudents = User::where('role', 'etudiant')->count();

    $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

    $totalCourses = Course::count();
    $courses = Course::with('lessons.quizzes')->get();

    $totalCertificates = Certificate::count();
    $certificates = Certificate::with(['user', 'course'])->latest()->take(10)->get();

    // Préparation données pour graphiques (exemple inscriptions utilisateurs par mois)
    $months = [];
    $usersPerMonth = [];

    $start = now()->subMonths(6);
    for ($i = 0; $i <= 6; $i++) {
        $month = $start->copy()->addMonths($i);
        $months[] = $month->format('M Y');
        $usersPerMonth[] = User::whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->count();
    }

    return view('admin.dashboard', compact(
        'totalUsers', 'totalAdmins', 'totalStudents', 'recentUsers',
        'totalCourses', 'courses',
        'totalCertificates', 'certificates',
        'months', 'usersPerMonth'
    ));
}

    public function indexcours()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }


        return view('admin.dashboard', [
            'courseCount' => Course::count(),
            'lessonCount' => Lesson::count(),
            'quizCount'   => Quiz::count(),
            'userCount'   => User::where('role', '!=', 'admin')->count(),
        ]);
    }
}
