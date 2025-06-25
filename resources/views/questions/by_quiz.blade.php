<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Questions du Quiz</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f4f8;
    margin: 0; padding: 0;
    color: #1e293b;
  }
  .container {
    max-width: 720px;
    margin: 2.5rem auto;
    background: #fff;
    padding: 1.75rem 2rem;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgb(0 0 0 / 0.1);
  }
  h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
  }
  p {
    font-size: 1rem;
    margin: 0.5rem 0;
  }
  p.text-gray-500 {
    color: #64748b;
  }
  p.text-red-500 {
    color: #dc2626;
    font-weight: 600;
  }
  a.button, a.inline-block {
    display: inline-block;
    background-color: #2563eb;
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    box-shadow: 0 2px 8px rgb(37 99 235 / 0.4);
    transition: background-color 0.3s ease;
    margin-bottom: 1.5rem;
  }
  a.button:hover, a.inline-block:hover {
    background-color: #1e40af;
  }
  ul.space-y-6 {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }
  ul.space-y-6 > li:not(:last-child) {
    margin-bottom: 1.5rem;
  }
  li {
    background: #f9fafb;
    border-radius: 8px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 10px rgb(0 0 0 / 0.05);
  }
  p.font-semibold {
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 0.5rem;
  }
  p.text-sm {
    font-size: 0.875rem;
  }
  ul.ml-4 {
    margin-left: 1.25rem;
    padding-left: 0;
    list-style: none;
  }
  ul.ml-4 li {
    margin-bottom: 0.4rem;
  }
  ul.ml-4 li.text-green-600 {
    color: #16a34a;
    font-weight: 700;
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Questions pour le quiz : {{ $quiz->title }}</h2>

    @if ($quiz->questions->isEmpty())
      <p class="text-gray-500">Aucune question pour ce quiz.</p>
    @else
      <a href="{{ route('questions.create', ['quiz' => $quiz->id]) }}" class="button">➕ Ajouter une question</a>
      <ul class="space-y-6">
        @foreach ($quiz->questions as $question)
          <li>
            <p class="font-semibold">❓ {{ $question->question_text }}</p>

            @if ($question->explanation)
              <p class="text-sm text-gray-500">💡 Explication : {{ $question->explanation }}</p>
            @endif

            @if ($question->answers->isNotEmpty())
              <ul class="ml-4">
                @foreach ($question->answers as $answer)
                  <li class="{{ $answer->is_correct ? 'text-green-600' : '' }}">
                    - {{ $answer->answer_text }} {!! $answer->is_correct ? '✅' : '' !!}
                  </li>
                @endforeach
              </ul>
            @else
              <p class="text-sm text-red-500">⚠️ Aucune réponse définie pour cette question.</p>
            @endif
          </li>
        @endforeach
      </ul>
    @endif

    <a href="{{ route('quizzes.index') }}" class="inline-block">⬅ Retour à la liste des quizzes</a>
  </div>
</body>
</html>
