<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 40px 20px;
        }

        .course-container {
            background: #fff;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .course-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .course-image {
            width: 100%;
            max-height: 280px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .course-title {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
        }

        .badge {
            background-color: #6366f1;
            color: white;
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 999px;
            margin-top: 10px;
            display: inline-block;
        }

        .course-description {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #475569;
        }

        .start-btn {
            margin: 25px auto;
            display: block;
            background: #22c55e;
            color: white;
            font-weight: bold;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .start-btn:hover {
            background: #16a34a;
        }

        .lesson {
            background: #f9fafb;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .lesson-title {
            font-weight: bold;
            color: #1d4ed8;
            font-size: 18px;
        }

        .quiz {
            margin-left: 20px;
            margin-top: 8px;
            font-size: 15px;
            color: #2563eb;
        }

        .no-quiz {
            color: #ef4444;
            margin-left: 20px;
            font-size: 14px;
            margin-top: 5px;
        }

        #comment-section {
  margin-top: 50px;
  background-color: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

#commentToggleBtn {
  background-color: #334155;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background 0.3s;
}

#commentToggleBtn:hover {
  background-color: #1e293b;
}

#commentForm textarea {
  width: 100%;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 12px;
  font-size: 14px;
  resize: vertical;
}

#commentForm button {
  background-color: #2563eb;
  color: white;
  font-weight: bold;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  transition: background 0.3s;
}

#commentForm button:hover {
  background-color: #1d4ed8;
}

#comment-section h4 {
  margin-top: 20px;
  font-size: 20px;
  color: #1e293b;
  border-bottom: 2px solid #e2e8f0;
  padding-bottom: 8px;
}

#comment-section .comment {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 15px;
}

#comment-section .comment strong {
  color: #1e40af;
}

#comment-section .comment small {
  color: #64748b;
}

    </style>
</head>
<body>
    <div class="course-container">
        <div class="course-header">
            <h1 class="course-title">{{ $course->title }}</h1>
            <span class="badge">{{ $course->category }}</span>
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="Image du cours" class="course-image">
            @endif
            <p class="course-description">{{ $course->description }}</p>
        </div>

        <a href="{{ route('courses.start', $course->id) }}" class="btn btn-primary start-btn">
            🚀 Commencer le cours
        </a>


        <h2 style="font-size: 24px; margin-top: 40px; color:#1e293b;">📚 Leçons</h2>

        @forelse ($course->lessons as $lesson)
            <div class="lesson">
                <div class="lesson-title">{{ $lesson->title }}</div>

                @if ($lesson->quizzes->count() > 0)
                    @foreach ($lesson->quizzes as $quiz)
                        <div class="quiz">📝 Quiz : {{ $quiz->title }}</div>
                    @endforeach
                @else
                    <div class="no-quiz">❌ Aucun quiz disponible pour cette leçon.</div>
                @endif
            </div>
        @empty
            <p style="color: red; margin-top: 10px;">Ce cours ne contient aucune leçon.</p>
        @endforelse
        <hr style="margin-top: 40px;">

<div id="comment-section">
  <button class="btn btn-secondary mb-3" onclick="toggleCommentForm()" id="commentToggleBtn">
    💬 Laisser un commentaire ▼
  </button>

  <div id="commentForm" style="display: none;">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('courses.comment.store', $course->id) }}">
      @csrf
      <textarea name="comment_text" class="form-control" rows="4" placeholder="Votre commentaire..." required></textarea>
      <button type="submit" class="btn btn-primary mt-2">Envoyer</button>
    </form>
  </div>

  <h4 style="margin-top: 30px;">🗨️ Commentaires</h4>
  @forelse ($course->comments as $comment)
    <div style="background: #f8fafc; padding: 10px 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #e2e8f0;">
      <strong>{{ $comment->user->name }}</strong>
      <small style="color: gray;"> — {{ $comment->created_at->diffForHumans() }}</small>
      <p style="margin-top: 5px;">{{ $comment->comment_text }}</p>
    </div>
  @empty
    <p>Aucun commentaire pour ce cours.</p>
  @endforelse
</div>



    </div>
    <script>
  function toggleCommentForm() {
    const form = document.getElementById('commentForm');
    const btn = document.getElementById('commentToggleBtn');

    if (form.style.display === 'none') {
      form.style.display = 'block';
      btn.innerHTML = '💬 Laisser un commentaire ▲';
    } else {
      form.style.display = 'none';
      btn.innerHTML = '💬 Laisser un commentaire ▼';
    }
  }
</script>
</body>
</html>
