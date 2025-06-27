<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le cours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Trix Editor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 700px;
        }

        trix-editor {
            min-height: 200px;
            background: #ffffff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .5rem;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Modifier le cours</h1>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre du cours</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input id="description" type="hidden" name="description" value="{{ old('description', $course->description) }}">
            <trix-editor input="description"></trix-editor>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image actuelle</label><br>
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" width="150" class="img-thumbnail mb-2"
                     alt="Image du cours">
            @else
                <p class="text-muted">Aucune image</p>
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<!-- Trix Editor JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
