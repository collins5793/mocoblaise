<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseController extends Controller
{
    public function index(Request $request)
{
  
    $search = $request->input('search');

    $query = Course::with('lessons.quizzes');
    // ->where('admin_id', Auth::id());

    if ($search) {
        $query->where('title', 'like', "%$search%");
    }
    if ($date = $request->input('date')) {
        // Recherche sur la date de création précise
        $query->whereDate('created_at', $date);
    }

    $courses = $query->paginate(10);

    return view('courses.index', compact('courses'));
}


    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        return view('courses.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'admin_id'    => Auth::id(),
        ]);

        return redirect()->route('lessons.create', ['course' => $course->id])
        ->with('success', 'Cours créé avec succès. Ajoutez maintenant les leçons.');
    }

    public function edit(Course $course)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->image = $request->file('image')->store('courses', 'public');
        }

        $course->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $course->image,
        ]);

        return redirect()->route('courses.index')->with('success', 'Cours mis à jour');
    }

    public function destroy(Course $course)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Cours supprimé');
    }

    public function show($id)
    {
                $user = Auth::user();

        $course = Course::with(['lessons.quizzes'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function byCategory($category)
    {
                $user = Auth::user();

        $courses = Course::where('category', $category)->get();
        return view('courses.by-category', compact('courses', 'category'));
    }

    public function all(Request $request)
    {
                $user = Auth::user();

        $search = $request->input('search');
        $courses = Course::query();

        if ($search) {
            $courses->where('title', 'like', "%$search%");
        }

        return view('courses.all', [
            'courses' => $courses->paginate(9),
            'search' => $search
        ]);
    }

    public function markAsCompleted($courseId)
{
            $user = Auth::user();

    $user = Auth::user();
    $course = \App\Models\Course::with('lessons.quizzes')->findOrFail($courseId);

    // 1. Leçons attendues
    $lessonIds = $course->lessons->pluck('id')->toArray();
    $totalLessons = count($lessonIds);

    // Leçons complétées
    $completedLessons = \App\Models\UserProgress::where('user_id', $user->id)
        ->whereIn('lesson_id', $lessonIds)
        ->where('is_completed', true)
        ->count();

    // 2. Quiz attendus
    $quizIds = $course->lessons->flatMap(function ($lesson) {
        return $lesson->quizzes->pluck('id');
    })->toArray();

    $totalQuizzes = count($quizIds);

    // Quiz passés
    $completedQuizzes = \App\Models\UserQuizAttempt::where('user_id', $user->id)
        ->whereIn('quiz_id', $quizIds)
        ->where('passed', true)
        ->distinct('quiz_id') // éviter les doublons si plusieurs tentatives
        ->count('quiz_id');

    // 3. Vérification
    if ($totalLessons > 0 && $completedLessons === $totalLessons &&
        $totalQuizzes === $completedQuizzes) {

        // ✅ Enregistrement comme terminé
        \App\Models\UserCourse::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'status' => 'terminé',
                'completed_at' => now(),
                'progress' => 100
            ]
        );

        return redirect()->route('dashboard')->with('success', '🎉 Cours terminé avec succès !');
    }

    return redirect()->back()->with('error', 'Vous devez terminer toutes les leçons et réussir tous les tests pour valider ce cours.');
}



public function exportCsv()
{
    if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    $courses = Course::with('lessons.quizzes')->get();

    $response = new StreamedResponse(function () use ($courses) {
        $handle = fopen('php://output', 'w');
        // Entêtes CSV
        fputcsv($handle, ['ID', 'Titre', 'Description', 'Nb Leçons', 'Nb Quiz']);

        foreach ($courses as $course) {
            $nbLessons = $course->lessons->count();
            $nbQuizzes = $course->lessons->sum(fn($l) => $l->quizzes->count());

            fputcsv($handle, [
                $course->id,
                $course->title,
                strip_tags($course->description),
                $nbLessons,
                $nbQuizzes,
            ]);
        }

        fclose($handle);
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="cours.csv"',
    ]);

    return $response;
}



}
