<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un nouveau cours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Trix Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.css">

    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

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
    <h1 class="mb-4 text-center">Créer un nouveau cours</h1>

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

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre du cours</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input id="description" type="hidden" name="description" value="{{ old('description') }}">
            <trix-editor input="description"></trix-editor>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optionnelle)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>

<!-- Trix Editor JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
