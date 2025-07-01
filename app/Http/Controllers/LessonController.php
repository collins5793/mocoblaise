<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCourse;

class LessonController extends Controller
{

public function index(Request $request, $courseId)
{
    $search = $request->input('search');

    $course = Course::findOrFail($courseId);

    $lessonsQuery = Lesson::where('course_id', $courseId);

    if ($search) {
        $lessonsQuery->where('title', 'like', "%{$search}%");
    }
    if ($date = $request->input('date')) {
        $query->whereDate('created_at', $date);
    }

    $lessons = $lessonsQuery->orderBy('order')->paginate(10);

    return view('lessons.index', compact('course', 'lessons'));
}


    // Affiche le formulaire pour ajouter des leçons à un cours
    public function create(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $courseId = $request->course;
        return view('lessons.create', compact('courseId'));
    }

    // Enregistre les leçons envoyées depuis le formulaire
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lessons' => 'required|array',
            'lessons.*.title' => 'required|string',
            'lessons.*.content_type' => 'required|in:texte,pdf,document',
            'lessons.*.content_url' => 'required|string',
            'lessons.*.order' => 'nullable|integer',
        ]);

        foreach ($request->lessons as $lessonData) {
            Lesson::create([
                'course_id' => $request->course_id,
                'title' => $lessonData['title'],
                'content_type' => $lessonData['content_type'],
                'content_url' => $lessonData['content_url'],
                'order' => $lessonData['order'] ?? 0,
            ]);
        }

        return redirect()->route('courses.index')->with('success', 'Leçons ajoutées avec succès.');
    }

    // Redirige vers la première leçon d’un cours
    public function start(Course $course)
    {
        $lesson = $course->lessons()->orderBy('order')->first();

        if (!$lesson) {
            return redirect()->back()->with('error', 'Aucune leçon disponible pour ce cours.');
        }

        return redirect()->route('lessons.show', [
            'course' => $course->id,
            'lesson' => $lesson->id
        ]);
    }

    public function edit(Lesson $lesson)
{
    if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    return view('lessons.edit', compact('lesson'));
}


public function update(Request $request, Lesson $lesson)
{
    if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    $request->validate([
        'title' => 'required|string|max:255',
        'content_type' => 'required|in:texte,pdf,document',
        'content_url' => 'required|string',
        'order' => 'nullable|integer',
    ]);

    $data = $request->only('title', 'content_type', 'order');

    // Si contenu texte, le contenu est dans content_url, sinon c'est une URL
    $data['content_url'] = $request->input('content_url');

    $lesson->update($data);

    return redirect()->route('lessons.index', $lesson->course_id)
        ->with('success', 'Leçon mise à jour avec succès.');
}

public function all()
{
    $lessons = Lesson::paginate(20); // par ex.
    return view('lessons.all', compact('lessons'));
}




    // Affiche une leçon spécifique
    public function show(Course $course, Lesson $lesson)
{
    $hasQuiz = $lesson->quizzes()->exists();

    $nextLesson = $course->lessons()
        ->where('order', '>', $lesson->order)
        ->orderBy('order')
        ->first();

    $user = Auth::user();

    // Vérifier si le cours est terminé
    $userCourse = UserCourse::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->where('status', 'terminé')
        ->first();

    return view('lessons.show', [
        'course' => $course,
        'lesson' => $lesson,
        'hasQuiz' => $hasQuiz,
        'nextLesson' => $nextLesson,
        'courseCompleted' => $userCourse !== null, // true si terminé
    ]);
}


    public function markAsCompleted(Request $request, Lesson $lesson)
{
    $user = Auth::user();

    // Vérifie si la progression existe déjà
    $progress = \App\Models\UserProgress::firstOrNew([
        'user_id' => $user->id,
        'lesson_id' => $lesson->id,
    ]);

    $progress->is_completed = true;
    $progress->completed_at = now();
    $progress->save();

    // Rediriger selon la logique (test ou leçon suivante)
    if ($request->has('goto_quiz')) {
        return redirect()->route('quizzes.start', ['lesson' => $lesson->id]);
    }

    if ($request->has('goto_next')) {
        $course = $lesson->course;
        $nextLesson = $course->lessons()->where('order', '>', $lesson->order)->orderBy('order')->first();

        if ($nextLesson) {
            return redirect()->route('lessons.show', ['course' => $course->id, 'lesson' => $nextLesson->id]);
        } else {
            return redirect()->route('dashboard')->with('success', '🎉 Vous avez terminé ce cours.');
        }
    }

    return redirect()->back()->with('success', 'Progression enregistrée.');
}

public function destroy(Lesson $lesson)
{
    if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
    $courseId = $lesson->course_id;
    $lesson->delete();

    return redirect()->route('lessons.index', $courseId)->with('success', 'Leçon supprimée.');
}



}
