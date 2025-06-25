<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter des Leçons</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f3f4f6;
      margin: 0;
      padding: 0;
      color: #1f2937;
    }

    .container {
      max-width: 800px;
      margin: 3rem auto;
      padding: 2rem;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    h1 {
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      font-weight: bold;
      color: #111827;
    }

    h2 {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      font-weight: 600;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #374151;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 0.65rem;
      margin-bottom: 1rem;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 1rem;
      background-color: #f9fafb;
    }

    .lesson-group {
      padding: 1.5rem;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      background-color: #f1f5f9;
    }

    button {
      padding: 0.6rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-add {
      background-color: #16a34a;
      color: white;
      margin-right: 0.8rem;
    }

    .btn-add:hover {
      background-color: #15803d;
    }

    .btn-submit {
      background-color: #2563eb;
      color: white;
    }

    .btn-submit:hover {
      background-color: #1d4ed8;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Ajouter des Leçons</h1>

    <form method="POST" action="{{ route('lessons.store') }}">
      @csrf
      <input type="hidden" name="course_id" value="{{ $courseId }}">

      <div id="lesson-fields">
        <div class="lesson-group">
          <h2>Leçon 1</h2>

          <label for="title0">Titre</label>
          <input type="text" id="title0" name="lessons[0][title]" required>

          <label for="type0">Type de contenu</label>
          <select name="lessons[0][content_type]" id="type0">
            <option value="texte">Texte</option>
            <option value="pdf">PDF</option>
            <option value="document">Document</option>
          </select>

          <label for="url0">URL du contenu</label>
          <input type="text" id="url0" name="lessons[0][content_url]" required>

          <label for="order0">Ordre (facultatif)</label>
          <input type="number" id="order0" name="lessons[0][order]">
        </div>
      </div>

      <button type="button" class="btn-add" onclick="addLesson()">Ajouter une autre leçon</button>
      <button type="submit" class="btn-submit">Valider les leçons</button>
    </form>
  </div>

  <script>
    let lessonCount = 1;

    function addLesson() {
      const container = document.getElementById('lesson-fields');

      const html = `
        <div class="lesson-group">
          <h2>Leçon ${lessonCount + 1}</h2>

          <label for="title${lessonCount}">Titre</label>
          <input type="text" id="title${lessonCount}" name="lessons[${lessonCount}][title]" required>

          <label for="type${lessonCount}">Type de contenu</label>
          <select name="lessons[${lessonCount}][content_type]" id="type${lessonCount}">
            <option value="texte">Texte</option>
            <option value="pdf">PDF</option>
            <option value="document">Document</option>
          </select>

          <label for="url${lessonCount}">URL du contenu</label>
          <input type="text" id="url${lessonCount}" name="lessons[${lessonCount}][content_url]" required>

          <label for="order${lessonCount}">Ordre (facultatif)</label>
          <input type="number" id="order${lessonCount}" name="lessons[${lessonCount}][order]">
        </div>
      `;

      container.insertAdjacentHTML('beforeend', html);
      lessonCount++;
    }
  </script>

</body>
</html>
