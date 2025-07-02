<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>{{ $lesson->title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9fafb;
      font-family: 'Segoe UI', sans-serif;
    }
    .lesson-container {
      max-width: 900px;
      margin: 2rem auto;
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .lesson-title {
      font-size: 1.8rem;
      font-weight: bold;
      color: #1f2937;
      margin-bottom: 1.5rem;
    }
    .lesson-content {
      margin-bottom: 2rem;
    }
    .btn-next {
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      border: none;
      border-radius: 8px;
      color: white;
      background-color: #2563eb;
    }
    .btn-next:hover {
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


<div class="lesson-container">
  <div class="lesson-title">{{ $lesson->title }}</div>

  <div class="lesson-content">
    @if($lesson->content_type === 'texte')
      {!! $lesson->content_url !!}
    @elseif($lesson->content_type === 'pdf' || $lesson->content_type === 'document')
      <iframe src="{{ $lesson->content_url }}" width="100%" height="500px" style="border: 1px solid #ccc; border-radius: 8px;"></iframe>
    @else
      <p class="text-danger">Type de contenu non pris en charge.</p>
    @endif
      </div>

      <div class="d-flex justify-content-end">
       <form method="POST" action="{{ route('lessons.complete', $lesson->id) }}">
  @csrf

  @if ($hasQuiz)
    <input type="hidden" name="goto_quiz" value="1">
    <button type="submit" class="btn btn-success mt-4">
        ✅ Passer le test de la leçon
    </button>
  @else
    @if ($nextLesson)
      <input type="hidden" name="goto_next" value="1">
      <button type="submit" class="btn btn-primary mt-4">
          ⏭️ Chapitre suivant
      </button>
    @else
   
    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">
      ✍️ Laisser un commentaire
    </a>
    @endif
  @endif
</form>
<!-- Si le cours n’est pas encore terminé -->
@if (!$courseCompleted && !$nextLesson && !$hasQuiz)
  <form action="{{ route('courses.complete', ['course' => $course->id]) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-warning mt-3">✅ Terminer ce cours</button>
  </form>
@endif

<!-- Si le cours est terminé -->
@if ($courseCompleted)
  <a href="{{ route('certificates.generate', ['course' => $course->id]) }}" class="btn btn-success mt-3">
    🎓 Obtenir mon certificat
  </a>
  <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary mt-3">
    ✍️ Laisser un commentaire
  </a>
@endif


  </div>
</div>

</body>
</html>