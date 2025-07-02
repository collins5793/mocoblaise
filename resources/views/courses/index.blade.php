@extends('layouts.app')

@section('title', 'Liste des cours')

@section('content')
    <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">📚 Mes cours</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('courses.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
            ➕ Créer un cours
        </a>
    </div>

    <form method="GET" action="{{ route('courses.index') }}" class="mb-6 flex flex-wrap gap-4 items-center">
        <input type="text" name="search" placeholder="Rechercher un cours" value="{{ request('search') }}"
            class="p-2 rounded border border-gray-300 w-72" />

        <input type="date" name="date" value="{{ request('date') }}"
            class="p-2 rounded border border-gray-300 max-w-xs" />

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Rechercher</button>

        <a href="{{ route('courses.exportCsv') }}"
            class="ml-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition whitespace-nowrap">
            Exporter CSV
        </a>
    </form>

    @if ($courses->count() > 0)
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full table-auto text-left border-collapse">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="p-4">Titre</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Image</th>
                        <th class="p-4">Date création</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-800">{{ $course->title }}</td>
                            <td class="p-4 text-gray-700">
                                {{ \Illuminate\Support\Str::limit(strip_tags($course->description), 60) }}</td>
                            <td class="p-4">
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="Image cours"
                                        class="w-24 rounded shadow" />
                                @else
                                    <span class="text-gray-500 italic">Aucune</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">{{ $course->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('courses.edit', $course->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    ✏️ Modifier
                                </a>

                                <a href="{{ route('lessons.index', ['course' => $course->id]) }}"
                                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-sm">
                                    📚 Leçons
                                </a>

                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce cours ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        🗑 Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $courses->withQueryString()->links() }}
        </div>
    @else
        <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded">
            Aucun cours disponible.
        </div>
    @endif
@endsection
