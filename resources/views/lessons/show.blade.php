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
        @if ($hasQuiz)
        <a href="{{ route('quizzes.start', ['lesson' => $lesson->id]) }}" class="btn btn-success mt-4">
            Passer le test de la leçon
        </a>
    @else
        @php
            $nextLesson = $course->lessons()->where('order', '>', $lesson->order)->orderBy('order')->first();
        @endphp

        @if ($nextLesson)
            <a href="{{ route('lessons.show', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}" class="btn btn-primary mt-4">
                Chapitre suivant
            </a>
        @else
            <span class="text-muted mt-4 d-block">Dernier chapitre du cours.</span>
        @endif
    @endif
  </div>
</div>

</body>
</html>
