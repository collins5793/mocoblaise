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

    @if ($courses->count() > 0)
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full table-auto text-left border-collapse">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="p-4">Titre</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Image</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr class="border-t">
                            <td class="p-4">{{ $course->title }}</td>
                            <td class="p-4">{{ Str::limit($course->description, 50) }}</td>
                            <td class="p-4">
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="w-24 h-auto rounded shadow"
                                        alt="Image">
                                @else
                                    <span class="text-gray-500 italic">Aucune</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('courses.edit', $course->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    ✏️ Modifier
                                </a>

                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
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
    @else
        <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded">
            Aucun cours disponible.
        </div>
    @endif
@endsection
