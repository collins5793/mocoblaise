<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Créer un nouveau Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9fafb;
      margin: 0; padding: 0;
      color: #1e293b;
    }
    .container {
      max-width: 600px;
      margin: 3rem auto;
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
    }
    h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #334155;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }
    input[type="text"],
    input[type="number"],
    select {
      padding: 0.6rem 1rem;
      font-size: 1rem;
      border: 1.5px solid #cbd5e1;
      border-radius: 6px;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 4px #2563ebaa;
    }
    button {
      background-color: #2563eb;
      color: white;
      padding: 0.75rem 1rem;
      font-weight: 600;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #1e40af;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Créer un nouveau Quiz</h1>
    <form action="{{ route('quizzes.store') }}" method="POST">
      @csrf
      <input type="text" name="title" placeholder="Titre" required />
      <input type="number" name="duration_minutes" placeholder="Durée (minutes)" min="1" required />

      <select name="lesson_id" required>
        <option value="" disabled selected>Choisir une leçon</option>
        @foreach ($lessons as $lesson)
          <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
        @endforeach
      </select>

      <button type="submit">Créer</button>
    </form>
  </div>
</body>
</html>
