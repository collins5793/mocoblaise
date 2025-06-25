<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Questions</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f9fafb;
  margin: 0;
  padding: 20px;
  color: #333;
}

.container {
  max-width: 900px;
  margin: 0 auto;
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
  color: #4f46e5;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
}

table th, table td {
  border: 1px solid #e5e7eb;
  padding: 10px;
  text-align: left;
}

table th {
  background-color: #f3f4f6;
}

textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0 20px;
  border: 1px solid #d1d5db;
  border-radius: 4px;
  resize: vertical;
}

button {
  background-color: #4f46e5;
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

button:hover {
  background-color: #4338ca;
}

  </style>
</head>
<body>

  <div class="container">
    <h1>Gestion des Questions</h1>

    <!-- Liste des questions -->
    <div class="question-list">
      <h2>Liste des questions</h2>
      <table>
        <thead>
          <tr>
            <th>Question</th>
            <th>Explication</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="questionTableBody">
          <!-- Les lignes seront insérées dynamiquement en JS -->
        </tbody>
      </table>
    </div>

    <!-- Formulaire d'ajout/modification -->
    <div class="question-form">
      <h2 id="formTitle">Ajouter une question</h2>
      <form id="questionForm">
        <input type="hidden" id="questionId" value="">
        <label for="question_text">Texte de la question :</label>
        <textarea id="question_text" required></textarea>

        <label for="explanation">Explication (facultatif) :</label>
        <textarea id="explanation"></textarea>

        <button type="submit">Enregistrer</button>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('questionForm');
  const questionTableBody = document.getElementById('questionTableBody');
  const formTitle = document.getElementById('formTitle');

  let questions = [];
  let editingIndex = null;

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const text = document.getElementById('question_text').value;
    const explanation = document.getElementById('explanation').value;

    if (editingIndex !== null) {
      questions[editingIndex] = { text, explanation };
      editingIndex = null;
      formTitle.textContent = "Ajouter une question";
    } else {
      questions.push({ text, explanation });
    }

    form.reset();
    renderQuestions();
  });

  function renderQuestions() {
    questionTableBody.innerHTML = '';
    questions.forEach((q, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${q.text}</td>
        <td>${q.explanation}</td>
        <td>
          <button onclick="editQuestion(${index})">Modifier</button>
          <button onclick="deleteQuestion(${index})">Supprimer</button>
        </td>
      `;
      questionTableBody.appendChild(row);
    });
  }

  window.editQuestion = function (index) {
    const q = questions[index];
    document.getElementById('question_text').value = q.text;
    document.getElementById('explanation').value = q.explanation;
    editingIndex = index;
    formTitle.textContent = "Modifier la question";
  }

  window.deleteQuestion = function (index) {
    if (confirm("Supprimer cette question ?")) {
      questions.splice(index, 1);
      renderQuestions();
    }
  }
});

  </script>
</body>
</html>
