@extends('admin.layout')

@section('title', 'Gestion des Quiz')

@section('content')
<h2>Gestion des Quiz</h2>

<form method="GET" action="{{ route('quizzes.index') }}" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
    <input type="text" name="search" placeholder="Rechercher un quiz" value="{{ request('search') }}" 
        style="padding:0.5rem; width: 300px; border-radius:5px; border:1px solid #ccc;" />
    <button type="submit" 
            style="padding:0.5rem 1rem; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
        Rechercher
    </button>

    <a href="{{ route('quizzes.create') }}" 
       style="margin-left:auto; background:#28a745; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">
       ➕ Ajouter un quiz
    </a>
</form>

<table style="width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); border-radius:10px; overflow:hidden;">
    <thead>
        <tr style="background:#007bff; color:#fff;">
            <th style="padding:1rem;">Titre</th>
            <th>Leçon associée</th>
            <th>Durée (minutes)</th>
            <th style="width:220px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($quizzes as $quiz)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding:0.75rem;">{{ $quiz->title }}</td>
                <td>{{ $quiz->lesson?->title ?? '—' }}</td>
                <td>{{ $quiz->duration_minutes }}</td>
                <td>
                    <a href="{{ route('quizzes.edit', $quiz->id) }}" 
                       style="background:#007bff; color:white; padding:0.3rem 0.6rem; border-radius:5px; text-decoration:none; margin-right:5px;">
                       Modifier
                    </a>

                    <form method="POST" action="{{ route('quizzes.destroy', $quiz->id) }}" style="display:inline;" 
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce quiz ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                style="background:#dc3545; color:white; border:none; padding:0.3rem 0.6rem; border-radius:5px; cursor:pointer;">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="padding:1rem; text-align:center;">Aucun quiz trouvé.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 1rem;">
    {{ $quizzes->withQueryString()->links() }}
</div>
@endsection
