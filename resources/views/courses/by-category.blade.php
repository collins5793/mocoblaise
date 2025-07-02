@extends('layouts.app')

@section('title', "Cours - $category")

@section('content')
    <div class="container mx-auto px-4 py-12 max-w-7xl">

        <h1 class="text-3xl font-extrabold text-indigo-700 mb-8 select-none">
            Cours dans la catégorie : <span class="capitalize">{{ $category }}</span>
        </h1>

        @if ($courses->isEmpty())
            <p class="text-center text-gray-500 italic">Aucun cours trouvé pour cette catégorie.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($courses as $course)
                    <div
                        class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col">
                        <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/default-course.jpg') }}"
                            alt="{{ $course->title }}" class="h-44 w-full object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold mb-2 text-gray-900 truncate">{{ $course->title }}</h2>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {!! \Illuminate\Support\Str::limit(strip_tags($course->description), 120) !!}
                            </p>
                            <div class="mt-auto flex justify-between items-center">
                                <span
                                    class="text-sm text-indigo-600 font-semibold">{{ $course->category ?? 'Sans catégorie' }}</span>
                                <a href="{{ route('courses.show', $course->id) }}"
                                    class="text-indigo-700 font-semibold hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
                                    Voir le cours →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
