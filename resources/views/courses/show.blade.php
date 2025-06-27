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
    </div>
</body>
</html>
