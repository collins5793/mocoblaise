@extends('admin.layout')

@section('title', 'Gestion des leçons')

@section('content')
<h2>Gestion des leçons du cours : <strong>{{ $course->title }}</strong></h2>

<form method="GET" action="{{ route('lessons.index', ['course' => $course->id]) }}" style="margin-bottom: 1rem;">
    <input type="text" name="search" placeholder="Rechercher une leçon" value="{{ request('search') }}" 
        style="padding:0.5rem; width: 300px; border-radius:5px; border:1px solid #ccc;" />
    <button type="submit" style="padding:0.5rem 1rem; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Rechercher</button>

    <a href="{{ route('lessons.create', ['course' => $course->id]) }}" 
       style="float:right; background:#28a745; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">➕ Ajouter une leçon</a>
</form>

<table style="width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); border-radius:10px; overflow:hidden;">
    <thead>
        <tr style="background:#007bff; color:#fff;">
            <th style="padding:1rem;">Titre</th>
            <th>Description</th>
            <th>Date création</th>
            <th style="width:220px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($lessons as $lesson)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding:0.75rem;">{{ $lesson->title }}</td>
                <td>{{ \Illuminate\Support\Str::limit(strip_tags($lesson->content_url ?? ''), 60) }}</td>
                <td>{{ $lesson->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($lesson->quizzes()->count() > 0)
                        <a href="{{ route('quizzes.index', ['lesson' => $lesson->id]) }}" 
                           style="background:#17a2b8; color:white; padding:0.3rem 0.6rem; border-radius:5px; text-decoration:none; margin-right:5px;">Voir les quiz</a>
                    @endif

                    <a href="{{ route('lessons.edit', $lesson->id) }}" 
                       style="background:#007bff; color:white; padding:0.3rem 0.6rem; border-radius:5px; text-decoration:none; margin-right:5px;">Modifier</a>

                    <form method="POST" action="{{ route('lessons.destroy', $lesson->id) }}" style="display:inline;" 
                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette leçon ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:#dc3545; color:white; border:none; padding:0.3rem 0.6rem; border-radius:5px; cursor:pointer;">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="padding:1rem; text-align:center;">Aucune leçon trouvée.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 1rem;">
    {{ $lessons->withQueryString()->links() }}
</div>
@endsection
