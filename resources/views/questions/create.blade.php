<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Ajouter les questions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8fafc;
      margin: 0; padding: 0;
      color: #334155;
    }
    .container {
      max-width: 700px;
      margin: 3rem auto;
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
    }
    h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #1e293b;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.3rem;
      color: #475569;
    }
    input[type="text"], textarea {
      width: 100%;
      padding: 0.5rem 1rem;
      margin-bottom: 1rem;
      font-size: 1rem;
      border: 1.5px solid #cbd5e1;
      border-radius: 6px;
      transition: border-color 0.3s ease;
      resize: vertical;
    }
    input[type="text"]:focus, textarea:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 6px #2563ebaa;
    }
    .question-block {
      background: #f1f5f9;
      border-radius: 8px;
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      border: 1px solid #e2e8f0;
    }
    button {
      cursor: pointer;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    }
    button[type="button"] {
      background-color: #16a34a;
      color: white;
      padding: 0.6rem 1.25rem;
      margin-bottom: 1.5rem;
    }
    button[type="button"]:hover {
      background-color: #15803d;
    }
    button[type="submit"] {
      background-color: #2563eb;
      color: white;
      padding: 0.75rem 1.75rem;
    }
    button[type="submit"]:hover {
      background-color: #1e40af;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Ajouter les questions pour ce quiz</h1>

    <form method="POST" action="{{ route('questions.store', $quizId) }}" id="questionForm">
      @csrf
      <div id="questionsContainer">
        <div class="question-block">
          <label for="question_0">Question</label>
          <input type="text" name="questions[0][question_text]" id="question_0" required>

          <label for="explanation_0">Explication (facultatif)</label>
          <textarea name="questions[0][explanation]" id="explanation_0" rows="3"></textarea>
        </div>
      </div>

      <button type="button" onclick="addQuestion()">Ajouter une question</button>
      <br />
      <button type="submit">Valider toutes les questions</button>
    </form>
  </div>

  <script>
    let questionIndex = 1;

    function addQuestion() {
      const container = document.getElementById('questionsContainer');
      const block = document.createElement('div');
      block.className = 'question-block';
      block.innerHTML = `
        <label for="question_${questionIndex}">Question</label>
        <input type="text" name="questions[${questionIndex}][question_text]" id="question_${questionIndex}" required>

        <label for="explanation_${questionIndex}">Explication (facultatif)</label>
        <textarea name="questions[${questionIndex}][explanation]" id="explanation_${questionIndex}" rows="3"></textarea>
      `;
      container.appendChild(block);
      questionIndex++;
    }
  </script>

</body>
</html>
