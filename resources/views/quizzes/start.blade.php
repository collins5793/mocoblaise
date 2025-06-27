<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $quiz->title }} - Quiz</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
      padding: 2rem;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .course-info h1 {
      font-size: 1.8rem;
      color: #1e293b;
      margin-bottom: 0.5rem;
    }
    .course-info p {
      margin: 0.3rem 0;
      color: #334155;
    }
    #countdown {
      font-size: 1.2rem;
      font-weight: bold;
      color: #dc2626;
    }
    .question {
      margin-top: 2rem;
      padding: 1.5rem;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      background-color: #f1f5f9;
    }
    .question h4 {
      color: #1e293b;
    }
    .answers label {
      display: block;
      margin: 0.5rem 0;
    }
    .toggle-explication {
      cursor: pointer;
      color: #2563eb;
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }
    .explanation {
      display: none;
      background-color: #e0f2fe;
      margin-top: 0.5rem;
      padding: 0.8rem;
      border-left: 4px solid #3b82f6;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    .submit-btn {
      display: block;
      margin-top: 2rem;
      padding: 0.8rem 2rem;
      background-color: #2563eb;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .submit-btn:hover {
      background-color: #1d4ed8;
    }
  </style>
</head>

<body>

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container">
  <div class="course-info mb-4">
    <h1>{{ $quiz->title }}</h1>
    <p><strong>Cours :</strong> {{ $quiz->lesson->course->title }}</p>
    <p><strong>Leçon :</strong> {{ $quiz->lesson->title }}</p>
    <p><strong>Durée :</strong> {{ $quiz->duration_minutes }} minutes</p>
    <p><strong>Temps restant :</strong> <span id="countdown">--:--</span></p>
  </div>

  <form method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
    @csrf

    @foreach ($quiz->questions as $index => $question)
      <div class="question">
        <h4>Question {{ $index + 1 }}</h4>
        <p>{{ $question->question_text }}</p>

        <div class="toggle-explication" onclick="toggleExplanation({{ $index }})">
          ▶ Voir l'explication
        </div>
        <div class="explanation" id="explanation-{{ $index }}">
          {{ $question->explanation }}
        </div>

        <div class="answers">
          @php
            $correctCount = $question->answers->where('is_correct', 1)->count();
            $inputType = $correctCount > 1 ? 'checkbox' : 'radio';
          @endphp

          @foreach ($question->answers as $answer)
            <label>
              <input type="{{ $inputType }}"
                     name="answers[{{ $question->id }}][]"
                     value="{{ $answer->id }}">
              {{ $answer->answer_text }}
            </label>
          @endforeach
        </div>
      </div>
    @endforeach

    <button type="submit" class="submit-btn">✅ Soumettre le Quiz</button>
  </form>
</div>

<script>
  function toggleExplanation(index) {
    const el = document.getElementById('explanation-' + index);
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
  }

  // Récupérer la date d'expiration (timestamp JS en ms)
  const expirationTime = new Date("{{ $existingSession->expiration_time->toIso8601String() }}").getTime();

  function startCountdown() {
    const countdownEl = document.getElementById('countdown');
    const submitBtn = document.querySelector('.submit-btn');
    const inputs = document.querySelectorAll('input');

    function update() {
      const now = new Date().getTime();
      let timeLeft = Math.floor((expirationTime - now) / 1000); // secondes

      if (timeLeft < 0) timeLeft = 0;

      const minutes = Math.floor(timeLeft / 60);
      const seconds = timeLeft % 60;

      countdownEl.innerText = `${minutes}m ${seconds < 10 ? '0' : ''}${seconds}s`;

      if (timeLeft === 60) {
        alert("⏳ Attention ! Il ne vous reste qu'une minute !");
      }

      if (timeLeft <= 0) {
        clearInterval(interval);
        alert("⛔ Temps écoulé. Vous ne pouvez plus soumettre le quiz.");

        submitBtn.disabled = true;
        submitBtn.innerText = "⛔ Temps écoulé";
        submitBtn.style.backgroundColor = "#9ca3af";
        submitBtn.style.cursor = "not-allowed";

        inputs.forEach(input => input.disabled = true);
      }
    }

    update();
    const interval = setInterval(update, 1000);
  }

  document.addEventListener("DOMContentLoaded", startCountdown);
</script>

</body>
</html>
