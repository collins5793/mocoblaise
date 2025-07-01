<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index($question_id)
    {
                $user = Auth::user();

        $question = Question::findOrFail($question_id);
        $answers = $question->answers;
        return view('answers.index', compact('answers', 'question'));
    }

    public function create($quizId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('answers.create', compact('quiz'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        foreach ($request->questions as $questionData) {
            $questionId = $questionData['question_id'];
            foreach ($questionData['answers'] as $answer) {
                \App\Models\Answer::create([
                    'question_id' => $questionId,
                    'answer_text' => $answer['answer_text'],
                    'justification' => '', // optionnel
                    'is_correct' => isset($answer['is_correct']) ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('quizzes.index')->with('success', 'Réponses ajoutées avec succès.');
    }


    public function edit($question_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $answer = Answer::findOrFail($id);
        return view('answers.edit', compact('answer'));
    }

    public function update(Request $request, $question_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $request->validate([
            'answer_text' => 'required|string',
            'justification' => 'nullable|string',
            'is_correct' => 'required|boolean',
        ]);

        $answer = Answer::findOrFail($id);
        $answer->update($request->all());

        return redirect()->route('answers.index', $question_id)->with('success', 'Réponse modifiée');
    }

    public function destroy($question_id, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        Answer::destroy($id);
        return redirect()->route('answers.index', $question_id)->with('success', 'Réponse supprimée');
    }
}
