<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cours - {{ $category }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 40px 20px;
        }
        h1 {
            color: #4338ca;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }
        .card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .card-body {
            padding: 16px;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .card-category {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .card a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }
        .empty {
            text-align: center;
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Cours dans la catégorie : {{ $category }}</h1>

    @if($courses->isEmpty())
        <p class="empty">Aucun cours trouvé pour cette catégorie.</p>
    @else
        <div class="grid">
            @foreach ($courses as $course)
                <div class="card">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                    <div class="card-body">
                        <div class="card-title">{{ $course->title }}</div>
                        <div class="card-category">{{ $course->category }}</div>
                        <a href="#">Voir le cours</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
