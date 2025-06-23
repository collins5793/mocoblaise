<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des cours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1000px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">📚 Mes cours</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('courses.create') }}" class="btn btn-success">
                ➕ Créer un cours
            </a>
        </div>

        @if ($courses->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ Str::limit($course->description, 50) }}</td>
                                <td>
                                    @if ($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" width="100"
                                            class="img-thumbnail" alt="Image">
                                    @else
                                        <span class="text-muted">Aucune</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-primary">
                                        ✏️ Modifier
                                    </a>

                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            🗑 Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Aucun cours disponible.</div>
        @endif
    </div>

    <!-- Bootstrap JS pour les alertes -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
