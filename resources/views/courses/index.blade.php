@extends('admin.layout')

@section('title', 'Gestion des cours')

@section('content')
<h2>Gestion des cours</h2>

<form method="GET" action="{{ route('courses.index') }}" style="margin-bottom: 1rem; display:flex; gap:1rem; flex-wrap:wrap; align-items:center;">
    <input type="text" name="search" placeholder="Rechercher un cours" value="{{ request('search') }}" 
        style="padding:0.5rem; width: 300px; border-radius:5px; border:1px solid #ccc;" />

    <input type="date" name="date" value="{{ request('date') }}" 
        style="padding:0.5rem; border-radius:5px; border:1px solid #ccc; max-width: 160px;" />

    <button type="submit" style="padding:0.5rem 1rem; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Rechercher</button>

    <a href="{{ route('courses.exportCsv') }}" 
       style="margin-left:auto; background:#28a745; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">Exporter CSV</a>
</form>


<table style="width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); border-radius:10px; overflow:hidden;">
    <thead>
        <tr style="background:#007bff; color:#fff;">
            <th style="padding:1rem;">Titre</th>
            <th>Description</th>
            <th>Image</th>
            <th>Date création</th>
            <th style="width:180px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($courses as $course)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding:0.75rem;">{{ $course->title }}</td>
                <td>{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 60) }}</td>
                <td>
                    @if ($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="Image cours" width="60" style="border-radius:5px;">
                    @else
                        <span style="color:#888;">Aucune</span>
                    @endif
                </td>
                <td>{{ $course->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}" 
                       style="background:#007bff; color:white; padding:0.3rem 0.6rem; border-radius:5px; text-decoration:none; margin-right:5px;">Modifier</a>

                    <a href="{{ route('lessons.index', ['course' => $course->id]) }}" 
                       style="background:#17a2b8; color:white; padding:0.3rem 0.6rem; border-radius:5px; text-decoration:none; margin-right:5px;">Leçons</a>

                    <form method="POST" action="{{ route('courses.destroy', $course->id) }}" style="display:inline;" 
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:#dc3545; color:white; border:none; padding:0.3rem 0.6rem; border-radius:5px; cursor:pointer;">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="padding:1rem; text-align:center;">Aucun cours trouvé.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 1rem;">
    {{ $courses->withQueryString()->links() }}
</div>
@endsection
