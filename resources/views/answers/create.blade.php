<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter des réponses</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f3f4f6;
      padding: 2rem;
      color: #1f2937;
    }

    h2 {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .question-block {
      background: #fff;
      border: 1px solid #d1d5db;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      margin-bottom: 1.5rem;
    }

    h4 {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .input-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
      .input-group {
        flex-direction: row;
        align-items: center;
      }
    }

    input[type="text"] {
      flex: 1;
      padding: 0.5rem;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 0.95rem;
      background-color: #f9fafb;
    }

    label {
      display: flex;
      align-items: center;
      font-size: 0.9rem;
      color: #374151;
    }

    .btn-add {
      font-size: 0.9rem;
      color: #2563eb;
      background: none;
      border: none;
      cursor: pointer;
      margin-top: 0.5rem;
    }

    .btn-submit {
      padding: 0.75rem 1.5rem;
      background-color: #2563eb;
      color: white;
      font-weight: bold;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 1rem;
    }

    .btn-submit:hover {
      background-color: #1d4ed8;
    }

    .checkbox {
      margin-left: 0.5rem;
    }
  </style>
</head>
<body>

  <h2>Ajouter des réponses pour chaque question</h2>

  <form action="{{ route('answers.store') }}" method="POST">
    @csrf

    @foreach ($quiz->questions as $question)
      <div class="question-block">
        <h4>{{ $question->question_text }}</h4>
        <input type="hidden" name="questions[{{ $question->id }}][question_id]" value="{{ $question->id }}">

        <div id="answers-container-{{ $question->id }}">
          <!-- Réponse 1 -->
          <div class="input-group">
            <input type="text" name="questions[{{ $question->id }}][answers][0][answer_text]" placeholder="Réponse">
            <input type="text" name="questions[{{ $question->id }}][answers][0][justification]" placeholder="Justification">
            <label><input type="checkbox" name="questions[{{ $question->id }}][answers][0][is_correct]" class="checkbox"> Correct</label>
          </div>

          <!-- Réponse 2 -->
          <div class="input-group">
            <input type="text" name="questions[{{ $question->id }}][answers][1][answer_text]" placeholder="Réponse">
            <input type="text" name="questions[{{ $question->id }}][answers][1][justification]" placeholder="Justification">
            <label><input type="checkbox" name="questions[{{ $question->id }}][answers][1][is_correct]" class="checkbox"> Correct</label>
          </div>
        </div>

        <button type="button" onclick="addAnswerField({{ $question->id }})" class="btn-add">➕ Ajouter une réponse</button>
      </div>
    @endforeach

    <button type="submit" class="btn-submit">✅ Enregistrer toutes les réponses</button>
  </form>

  <script>
    function addAnswerField(questionId) {
      const container = document.getElementById(`answers-container-${questionId}`);
      const count = container.querySelectorAll('input[name*="answer_text"]').length;

      const div = document.createElement('div');
      div.className = 'input-group';
      div.innerHTML = `
        <input type="text" name="questions[${questionId}][answers][${count}][answer_text]" placeholder="Réponse">
        <input type="text" name="questions[${questionId}][answers][${count}][justification]" placeholder="Justification">
        <label><input type="checkbox" name="questions[${questionId}][answers][${count}][is_correct]" class="checkbox"> Correct</label>
      `;
      container.appendChild(div);
    }
  </script>

</body>
</html>
