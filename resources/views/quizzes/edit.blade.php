<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Modifier le Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f4f8;
      margin: 0; padding: 0;
      color: #1e293b;
    }
    .container {
      max-width: 600px;
      margin: 3rem auto;
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
    }
    h1 {
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #334155;
    }
    .success-msg {
      background-color: #dcfce7;
      color: #166534;
      padding: 1rem 1.25rem;
      border-radius: 6px;
      margin-bottom: 1.5rem;
      border: 1px solid #4ade80;
      font-weight: 600;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #475569;
    }
    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 0.6rem 1rem;
      font-size: 1rem;
      border: 1.5px solid #cbd5e1;
      border-radius: 6px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 5px #2563ebaa;
    }
    button {
      align-self: flex-end;
      background-color: #2563eb;
      color: white;
      padding: 0.75rem 1.5rem;
      font-weight: 700;
      font-size: 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #1e40af;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Modifier le Quiz</h1>

    @if(session('success'))
      <div class="success-msg">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div>
        <label for="title">Titre</label>
        <input
          type="text"
          name="title"
          id="title"
          value="{{ old('title', $quiz->title) }}"
          required
        />
      </div>

      <div>
        <label for="duration_minutes">Durée (minutes)</label>
        <input
          type="number"
          name="duration_minutes"
          id="duration_minutes"
          value="{{ old('duration_minutes', $quiz->duration_minutes) }}"
          min="1"
          required
        />
      </div>

      <div>
        <label for="is_active">Statut</label>
        <select name="is_active" id="is_active" required>
          <option value="1" {{ $quiz->is_active ? 'selected' : '' }}>Actif</option>
          <option value="0" {{ !$quiz->is_active ? 'selected' : '' }}>Inactif</option>
        </select>
      </div>

      @isset($lessons)
      <div>
        <label for="lesson_id">Leçon associée</label>
        <select name="lesson_id" id="lesson_id" required>
          @foreach ($lessons as $lesson)
            <option value="{{ $lesson->id }}" {{ $quiz->lesson_id == $lesson->id ? 'selected' : '' }}>
              {{ $lesson->title }}
            </option>
          @endforeach
        </select>
      </div>
      @endisset

      <button type="submit">Mettre à jour</button>
    </form>
  </div>
</body>
</html>
