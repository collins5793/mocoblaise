<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;

class LessonController extends Controller
{
    // Affiche le formulaire pour ajouter des leçons à un cours
    public function create(Request $request)
    {
        $courseId = $request->course;
        return view('lessons.create', compact('courseId'));
    }

    // Enregistre les leçons envoyées depuis le formulaire
    public function store(Request $request)
    {
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

    // Affiche une leçon spécifique
    public function show(Course $course, Lesson $lesson)
    {
        // Vérifie s'il y a au moins un quiz lié à cette leçon
        $hasQuiz = $lesson->quizzes()->exists();

        return view('lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'hasQuiz' => $hasQuiz
        ]);
    }
}
