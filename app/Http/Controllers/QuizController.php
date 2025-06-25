<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Lesson;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quizzes.index', compact('quizzes'));
        $quizzes = Quiz::with('lesson')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = \App\Models\Lesson::all();
        return view('quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:191',
            'duration_minutes' => 'required|integer',
        ]);

        $quiz = Quiz::create($request->all());

        return redirect()->route('questions.create', ['quiz' => $quiz->id]);
    }

    public function showByQuiz($quizId)
    {
        $quiz = \App\Models\Quiz::with(['questions.answers'])->findOrFail($quizId);
        return view('questions.by_quiz', compact('quiz'));
    }


    public function edit(Quiz $quiz)
    {
        $lessons = \App\Models\Lesson::all();
        return view('quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'duration_minutes' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        $quiz->update($request->all());

        return redirect()->route('quizzes.index')->with('success', 'Quiz mis à jour avec succès.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz supprimé avec succès.');
    }
}

