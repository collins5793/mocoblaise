<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 2rem 1rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1e293b;
        }

        .add-btn {
            background-color: #2563eb;
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s;
        }

        .add-btn:hover {
            background-color: #1e40af;
        }

        .alert {
            background-color: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border: 1px solid #e2e8f0;
        }

        th, td {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #334155;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .action-links a {
            margin-right: 0.75rem;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .action-links form {
            display: inline;
        }

        .action-links button {
            background: none;
            border: none;
            color: #dc2626;
            cursor: pointer;
            font-weight: 500;
        }

        .action-links button:hover {
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
            color: #6b7280;
            padding: 1rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Liste des Quiz</h1>
            <a href="{{ route('quizzes.create') }}" class="add-btn">+ Ajouter un Quiz</a>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Leçon</th>
                    <th>Durée</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->title }}</td>
                        <td>{{ $quiz->lesson ? $quiz->lesson->title : 'Non défini' }}</td>
                        <td>{{ $quiz->duration_minutes }} min</td>
                        <td class="action-links text-center">
                            <a href="{{ route('quizzes.edit', $quiz->id) }}">Modifier</a>

                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce quiz ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Supprimer</button>
                            </form>

                            <a href="{{ route('quizzes.questions', $quiz->id) }}" class="text-green-600">Voir les questions</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun quiz enregistré pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
