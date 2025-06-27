<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Résultats du Quiz - {{ $quiz->title }}</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fafb;
      margin: 0;
      padding: 2rem;
      color: #1f2937;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      padding: 2rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    h1, h2, h3 {
      color: #111827;
    }

    .summary {
      padding: 1rem;
      background-color: #e0f2fe;
      border-left: 5px solid #3b82f6;
      margin-bottom: 2rem;
      border-radius: 6px;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .summary.success {
      background-color: #dcfce7;
      border-color: #22c55e;
      color: #166534;
    }

    .summary.fail {
      background-color: #fee2e2;
      border-color: #ef4444;
      color: #991b1b;
    }

    .question {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 1.2rem;
      margin-bottom: 1.5rem;
      background-color: #f1f5f9;
    }

    .question h3 {
      margin-bottom: 0.5rem;
    }

    .answer {
      padding-left: 1rem;
      margin-bottom: 0.3rem;
    }

    .answer.correct {
      color: #22c55e;
      font-weight: bold;
    }

    .answer.incorrect {
      color: #ef4444;
      font-weight: bold;
      text-decoration: line-through;
    }

    .justification {
      margin-top: 0.8rem;
      background-color: #fef3c7;
      border-left: 4px solid #f59e0b;
      padding: 0.8rem;
      border-radius: 4px;
      font-style: italic;
      font-size: 0.9rem;
    }

    .btn-next {
      display: inline-block;
      margin-top: 2rem;
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      border: none;
      border-radius: 8px;
      color: white;
      background-color: #2563eb;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-next:hover {
      background-color: #1d4ed8;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Résultats du Quiz</h1>
    <div class="summary {{ $passed ? 'success' : 'fail' }}">
      Votre score : {{ round($score, 2) }}%
      <br />
      Statut : {{ $passed ? 'Réussi 🎉' : 'Échoué 😞' }}
    </div>

    @foreach ($quiz->questions as $index => $question)
      <div class="question">
        <h3>Question {{ $index + 1 }}</h3>
        <p>{{ $question->question_text }}</p>

        @php
          $correctAnswerIds = $question->answers->where('is_correct', 1)->pluck('id')->toArray();
          $userAnswerIds = $userAnswers[$question->id] ?? [];
          if (!is_array($userAnswerIds)) {
            $userAnswerIds = [$userAnswerIds];
          }
        @endphp

        @foreach ($question->answers as $answer)
          @php
            $isUserSelected = in_array($answer->id, $userAnswerIds);
            $isCorrect = $answer->is_correct == 1;
          @endphp
          <div
            class="answer
              {{ $isCorrect ? 'correct' : '' }}
              {{ !$isCorrect && $isUserSelected ? 'incorrect' : '' }}">
            @if ($isUserSelected)
              ✔️
            @else
              &nbsp;&nbsp;
            @endif
            {{ $answer->answer_text }}
          </div>
        @endforeach

        @if (!$passed && count(array_diff($correctAnswerIds, $userAnswerIds)) > 0)
          <div class="justification">
            <strong>Justification(s) :</strong><br />
            @foreach ($question->answers->whereIn('id', array_diff($correctAnswerIds, $userAnswerIds)) as $missedAnswer)
              - {{ $missedAnswer->justification }}<br />
            @endforeach
          </div>
        @endif
      </div>
    @endforeach

    @php
      $nextLesson = $lesson->course->lessons()->where('order', '>', $lesson->order)->orderBy('order')->first();
    @endphp

    @if ($nextLesson)
      <a href="{{ route('lessons.show', ['course' => $lesson->course->id, 'lesson' => $nextLesson->id]) }}" class="btn-next">
        Chapitre suivant
      </a>
    @else
      <button class="btn-next" disabled>Cours terminé</button>
    @endif
  </div>
</body>

</html>
