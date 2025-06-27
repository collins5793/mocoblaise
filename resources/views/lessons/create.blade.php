<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter des Leçons</title>

  <!-- Trix Editor CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

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

    trix-editor {
      background-color: white;
      min-height: 150px;
      margin-bottom: 1rem;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Ajouter des Leçons</h1>

  <form method="POST" action="{{ route('lessons.store') }}">
    @csrf

    @if ($errors->any())
      <div style="color: red; margin-bottom: 10px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <input type="hidden" name="course_id" value="{{ $courseId }}">

    <div id="lesson-fields">
      <div class="lesson-group" data-index="0">
        <h2>Leçon 1</h2>

        <label>Titre</label>
        <input type="text" name="lessons[0][title]" required>

        <label>Type de contenu</label>
        <select name="lessons[0][content_type]" class="content-type" onchange="handleTypeChange(this)">
          <option value="texte">Texte</option>
          <option value="pdf">PDF</option>
          <option value="document">Document</option>
        </select>

        <div class="content-texte">
          <input type="hidden" name="lessons[0][content_url]" id="content0">
          <trix-editor input="content0"></trix-editor>
        </div>

        <div class="content-url" style="display: none;">
          <label>URL du contenu</label>
          <input type="text" name="lessons[0][content_url_alt]">
        </div>

        <label>Ordre (facultatif)</label>
        <input type="number" name="lessons[0][order]">
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

    const newIndex = lessonCount;

    const group = document.createElement('div');
    group.classList.add('lesson-group');
    group.dataset.index = newIndex;

    group.innerHTML = `
      <h2>Leçon ${newIndex + 1}</h2>

      <label>Titre</label>
      <input type="text" name="lessons[${newIndex}][title]" required>

      <label>Type de contenu</label>
      <select name="lessons[${newIndex}][content_type]" class="content-type" onchange="handleTypeChange(this)">
        <option value="texte">Texte</option>
        <option value="pdf">PDF</option>
        <option value="document">Document</option>
      </select>

      <div class="content-texte">
        <input type="hidden" name="lessons[${newIndex}][content_url]" id="content${newIndex}">
        <trix-editor input="content${newIndex}"></trix-editor>
      </div>

      <div class="content-url" style="display: none;">
        <label>URL du contenu</label>
        <input type="text" name="lessons[${newIndex}][content_url_alt]">
      </div>

      <label>Ordre (facultatif)</label>
      <input type="number" name="lessons[${newIndex}][order]">
    `;

    container.appendChild(group);
    lessonCount++;
  }

  function handleTypeChange(select) {
    const group = select.closest('.lesson-group');
    const texteDiv = group.querySelector('.content-texte');
    const urlDiv = group.querySelector('.content-url');

    const hiddenInput = texteDiv.querySelector('input[type="hidden"]');
    const urlInput = urlDiv.querySelector('input[type="text"]');

    if (select.value === 'texte') {
      texteDiv.style.display = 'block';
      urlDiv.style.display = 'none';

      hiddenInput.disabled = false;
      urlInput.disabled = true;
    } else {
      texteDiv.style.display = 'none';
      urlDiv.style.display = 'block';

      hiddenInput.disabled = true;
      urlInput.disabled = false;
    }
  }
</script>

</body>
</html>
