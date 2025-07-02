@extends('layouts.app')

@section('title', 'Créer un nouveau cours')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Créer un nouveau cours</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Titre du cours</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>

                {{-- Hidden input lié à trix --}}
                <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                <trix-editor input="description"
                    class="trix-content bg-white border border-gray-300 rounded-md min-h-[200px]"></trix-editor>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Image (optionnelle)</label>
                <input type="file" name="image"
                    class="w-full border border-gray-300 rounded px-4 py-2 file:bg-blue-100 file:border-0 file:rounded file:mr-4">
            </div>

            <div class="flex justify-between">
                <a href="{{ route('courses.index') }}"
                    class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Retour
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    ➕ Créer
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
