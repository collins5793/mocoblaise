<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $questions = $quiz->questions;
        return view('questions.index', compact('questions', 'quiz'));
    }

    public function create($quizId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $quiz = Quiz::findOrFail($quizId);
        return view('questions.create', compact('quizId'));
    }

    public function store(Request $request, $quizId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'questions.*.question_text' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
        ]);

        foreach ($request->questions as $data) {
            Question::create([
                'quiz_id' => $quizId,
                'question_text' => $data['question_text'],
                'explanation' => $data['explanation'],
            ]);
        }
        

        return redirect()->route('answers.create', ['quiz' => $quizId]);
    }
    public function showByQuiz($quizId)
    {
        $quiz = \App\Models\Quiz::with(['questions.answers'])->findOrFail($quizId);
        return view('questions.by_quiz', compact('quiz'));
    }

    public function edit($quiz_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, $quiz_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->all());

        return redirect()->route('questions.index', $quiz_id)->with('success', 'Question modifiée');
    }

    public function destroy($quiz_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        Question::destroy($id);
        return redirect()->route('questions.index', $quiz_id)->with('success', 'Question supprimée');
    }
}
