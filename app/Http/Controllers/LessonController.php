<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function create(Request $request)
    {
        $courseId = $request->course;
        return view('lessons.create', compact('courseId'));
    }

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
}
