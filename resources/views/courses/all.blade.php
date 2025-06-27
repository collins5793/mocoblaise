<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .course-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .course-card:hover {
            transform: scale(1.02);
        }
        .course-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .badge {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: white;
            width: 90%;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            cursor: pointer;
            color: #333;
        }
        .lesson {
            margin-top: 15px;
            padding: 10px;
            border-left: 4px solid #4f46e5;
            background: #f1f5f9;
            border-radius: 4px;
        }
        .quiz {
            margin-left: 15px;
            font-size: 15px;
            color: #1e3a8a;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-3xl font-bold mb-6">Tous les cours</h2>
    <div class="courses-grid">
        @foreach ($courses as $course)
            <a href="{{ route('courses.show', $course->id) }}" class="course-card" style="text-decoration:none; color:inherit;">
                <div class="course-title">{{ $course->title }}</div>
                <p>{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                <span class="badge">{{ $course->category }}</span>
            </a>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal" id="courseModal">
    <div class="modal-content" id="modalContent">
        <span class="close-btn" onclick="closeModal()">&times;</span>
    </div>
</div>

<script>
    const courses = @json($courses->values());

    function closeModal() {
        document.getElementById('courseModal').style.display = 'none';
    }
</script>
</body>
</html>
