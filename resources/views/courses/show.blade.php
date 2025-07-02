@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="container mx-auto max-w-4xl px-4 py-12 bg-white rounded-xl shadow-lg">

        <header class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900">{{ $course->title }}</h1>
            <span class="inline-block mt-2 bg-indigo-600 text-white text-sm font-semibold px-4 py-1 rounded-full">
                {{ $course->category ?? 'Sans catégorie' }}
            </span>
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="Image du cours"
                    class="mt-6 w-full max-h-72 object-cover rounded-lg shadow-md mx-auto">
            @endif
            <p class="mt-6 text-gray-700 leading-relaxed">{{ $course->description }}</p>
        </header>

        <div class="text-center mb-12">
            <a href="{{ route('courses.start', $course->id) }}"
                class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition">
                🚀 Commencer le cours
            </a>
        </div>

        <section>
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">📚 Leçons</h2>

            @forelse ($course->lessons as $lesson)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-5 shadow-sm hover:shadow-md transition">
                    <h3 class="font-semibold text-indigo-700 text-lg">{{ $lesson->title }}</h3>

                    @if ($lesson->quizzes->count() > 0)
                        <ul class="mt-2 space-y-1 ml-5 list-disc text-indigo-600 text-sm">
                            @foreach ($lesson->quizzes as $quiz)
                                <li>📝 Quiz : {{ $quiz->title }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-red-500 mt-2 ml-5 text-sm">❌ Aucun quiz disponible pour cette leçon.</p>
                    @endif
                </div>
            @empty
                <p class="text-red-600 font-semibold">Ce cours ne contient aucune leçon.</p>
            @endforelse
        </section>

        <hr class="my-12 border-gray-300">

        <section id="comment-section" class="bg-white rounded-lg shadow-md p-6">
            <button id="commentToggleBtn" onclick="toggleCommentForm()"
                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-lg px-6 py-3 mb-6 transition">
                💬 Laisser un commentaire ▼
            </button>

            <div id="commentForm" class="hidden">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('courses.comment.store', $course->id) }}">
                    @csrf
                    <textarea name="comment_text" required
                        class="w-full border border-gray-300 rounded-md p-3 text-gray-800 resize-y focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        rows="4" placeholder="Votre commentaire..."></textarea>
                    <button type="submit"
                        class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md transition">
                        Envoyer
                    </button>
                </form>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-4">🗨️ Commentaires</h3>

            @forelse ($course->comments as $comment)
                <div class="border border-gray-200 rounded-md p-4 mb-4 bg-gray-50">
                    <p class="font-semibold text-indigo-700">{{ $comment->user->name }}
                        <span class="text-gray-500 text-sm font-normal">—
                            {{ $comment->created_at->diffForHumans() }}</span>
                    </p>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $comment->comment_text }}</p>
                </div>
            @empty
                <p class="text-gray-500 italic">Aucun commentaire pour ce cours.</p>
            @endforelse
        </section>
    </div>

    @push('scripts')
        <script>
            function toggleCommentForm() {
                const form = document.getElementById('commentForm');
                const btn = document.getElementById('commentToggleBtn');

                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                    btn.textContent = '💬 Laisser un commentaire ▲';
                } else {
                    form.classList.add('hidden');
                    btn.textContent = '💬 Laisser un commentaire ▼';
                }
            }
        </script>
    @endpush
@endsection
