<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\QuizSession;
use App\Models\Answer;
use App\Models\UserQuizAttempt;


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

public function start(Lesson $lesson)
{
    $user = Auth::user();

    $quiz = $lesson->quizzes()->where('is_active', true)->first();

    if (!$quiz) {
        return redirect()->back()->with('error', 'Aucun quiz actif pour cette leçon.');
    }

    // Vérifier si l'utilisateur a déjà échoué aujourd'hui
    $alreadyFailedToday = UserQuizAttempt::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->where('passed', false)
        ->whereDate('attempted_at', Carbon::today())
        ->exists();

    if ($alreadyFailedToday) {
        return redirect()->back()->with('error', 'Vous avez échoué au test aujourd\'hui. Réessayez demain.');
    }

    // Chercher session existante aujourd'hui
    $existingSession = QuizSession::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->whereDate('start_time', Carbon::today())
        ->where('status', 'en_cours')
        ->first();

    if ($existingSession) {
        // Vérifier expiration
        if (Carbon::now()->greaterThan($existingSession->expiration_time)) {
            $existingSession->update(['status' => 'expiré']);
            return redirect()->back()->with('error', 'Temps de test expiré. Revenez demain.');
        }
    } else {
        // Créer une nouvelle session
        $start = Carbon::now();
        $end = $start->copy()->addMinutes($quiz->duration_minutes);

        $existingSession = QuizSession::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'start_time' => $start,
            'expiration_time' => $end,
            'status' => 'en_cours',
        ]);
    }

    return view('quizzes.start', [
        'quiz' => $quiz,
        'lesson' => $lesson,
        'existingSession' => $existingSession,  // **important**
    ]);
}

public function submit(Request $request, Quiz $quiz)
{
    $user = Auth::user();
    $quiz = Quiz::with(['questions.answers'])->findOrFail($quiz->id);

    // Récupérer les réponses soumises (tableau question_id => array of answer_ids)
    $userAnswers = $request->input('answers', []);


    // Nombre total de bonnes réponses dans le quiz (somme des réponses correctes pour toutes questions)
    $totalCorrectAnswers = $quiz->questions->sum(function ($question) {
        return $question->answers->where('is_correct', 1)->count();
    });

    if ($totalCorrectAnswers === 0) {
        // Pas de bonnes réponses configurées (cas rare), éviter division par zéro
        return redirect()->back()->with('error', 'Le quiz ne contient aucune réponse correcte configurée.');
    }

    // Calculer le score total en pourcentage
    $scoreCount = 0; // nombre de bonnes réponses données par l'utilisateur

    foreach ($quiz->questions as $question) {
        $correctAnswerIds = $question->answers->where('is_correct', 1)->pluck('id')->toArray();

        // Réponses données par l'utilisateur à cette question
        $userAnswerIds = $userAnswers[$question->id] ?? [];
        if (!is_array($userAnswerIds)) {
            $userAnswerIds = [$userAnswerIds];
        }

        // Pour chaque réponse correcte, vérifier si l'utilisateur l'a choisie
        foreach ($correctAnswerIds as $correctId) {
            if (in_array($correctId, $userAnswerIds)) {
                $scoreCount++;
            }
        }
    }

    // Calculer le pourcentage : scoreCount / totalCorrectAnswers * 100
    $scorePercent = ($scoreCount / $totalCorrectAnswers) * 100;

    // Définir si l'utilisateur a réussi (>= 70%)
    $passed = $scorePercent >= 70;

    // Enregistrer la tentative
    UserQuizAttempt::create([
        'user_id' => $user->id,
        'quiz_id' => $quiz->id,
        'score' => $scorePercent,
        'passed' => $passed,
        'attempted_at' => Carbon::now(),
    ]);

    // Récupérer la leçon pour la vue (car la méthode reçoit $quiz seulement)
    $lesson = $quiz->lesson;

    // Passer les données à la vue résultats
    return view('quizzes.result', [
        'quiz' => $quiz,
        'lesson' => $lesson,
        'score' => $scorePercent,
        'passed' => $passed,
        'userAnswers' => $userAnswers,
    ]);
}



}

