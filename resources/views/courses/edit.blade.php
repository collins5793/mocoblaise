@extends('layouts.app')

@section('title', 'Modifier le cours')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Modifier le cours</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Titre du cours</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <input id="description" type="hidden" name="description"
                    value="{{ old('description', $course->description) }}">
                <trix-editor input="description"
                    class="trix-content bg-white border border-gray-300 rounded-md min-h-[200px]"></trix-editor>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Image actuelle</label>
                @if ($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="Image du cours"
                        class="w-32 h-auto rounded shadow mb-2">
                @else
                    <p class="text-gray-500 italic">Aucune image</p>
                @endif
                <input type="file" name="image"
                    class="w-full border border-gray-300 rounded px-4 py-2 mt-2 file:bg-blue-100 file:border-0 file:rounded file:mr-4">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('courses.index') }}"
                    class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    💾 Enregistrer
                </button>
            </div>
        </form>
    </div>

    {{-- Trix CSS/JS --}}
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    @endpush
@endsection
