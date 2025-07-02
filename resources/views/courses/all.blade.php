@extends('layouts.app')

@section('title', 'Tous les cours')

@section('content')
    <div class="relative container max-w-7xl mx-auto px-4 py-12">

        <!-- Modal -->
        <div id="courseModal"
            class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-50">
            <div
                class="bg-white rounded-lg max-w-3xl w-full p-6 max-h-[80vh] overflow-y-auto relative shadow-xl transform scale-90 transition-transform duration-300">
                <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-3xl font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                    aria-label="Fermer la fenêtre">&times;</button>
                <div id="modalContent" class="prose max-w-none">
                    <!-- Contenu dynamique chargé via JS -->
                    <p class="text-center text-gray-500">Chargement...</p>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold mb-8 text-gray-900 select-none">Tous les cours</h2>

        <input type="text" id="searchInput" placeholder="🔍 Rechercher un cours..."
            class="mb-8 w-full max-w-md p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />

        <div id="coursesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($courses as $course)
                <button type="button"
                    class="course-card bg-white rounded-lg shadow-md hover:shadow-2xl p-6 text-left cursor-pointer transition transform hover:-translate-y-2 hover:scale-[1.03] focus:outline-none focus:ring-4 focus:ring-indigo-300"
                    onclick="openModal({{ $course->id }})" data-title="{{ strtolower($course->title) }}">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 truncate">{{ $course->title }}</h3>
                    <p class="text-gray-600 mb-3 line-clamp-3">
                        {{ \Illuminate\Support\Str::limit(strip_tags($course->description), 120) }}</p>
                    <span
                        class="inline-block bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full select-none">
                        {{ $course->category ?? 'Sans catégorie' }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            const courses = @json($courses->keyBy('id'));

            function openModal(courseId) {
                const modal = document.getElementById('courseModal');
                const content = document.getElementById('modalContent');

                const course = courses[courseId];
                if (!course) {
                    content.innerHTML = '<p class="text-red-500 font-semibold">Cours non trouvé.</p>';
                } else {
                    let imageHtml = '';
                    if (course.image) {
                        imageHtml =
                            `<img src="/storage/${course.image}" alt="Image de ${course.title}" class="mb-4 rounded-lg shadow-md w-full object-cover max-h-60">`;
                    }
                    content.innerHTML = `
                ${imageHtml}
                <h2 class="text-3xl font-bold mb-4">${course.title}</h2>
                <p class="mb-4">${course.description || 'Pas de description disponible.'}</p>
                <p><strong>Catégorie :</strong> ${course.category || 'Non spécifiée'}</p>
                ${course.lessons && course.lessons.length > 0 ? `
                            <h3 class="mt-6 font-semibold text-indigo-700">Leçons</h3>
                            <ul class="list-disc list-inside space-y-2">
                                ${course.lessons.map(lesson => `
                            <li>
                                <strong>${lesson.title}</strong>
                                ${lesson.quiz ? `<div class="ml-4 mt-1 inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-0.5 rounded-full select-none">📝 Quiz: ${lesson.quiz.title}</div>` : ''}
                            </li>
                        `).join('')}
                            </ul>
                        ` : '<p class="mt-4 text-gray-500 italic">Aucune leçon disponible.</p>'}
            `;
                }
                modal.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    modal.querySelector('div').classList.remove('scale-90');
                }, 20);
            }

            function closeModal() {
                const modal = document.getElementById('courseModal');
                modal.querySelector('div').classList.add('scale-90');
                setTimeout(() => {
                    modal.classList.add('opacity-0', 'pointer-events-none');
                }, 200);
            }

            // Fermer modal si clic hors contenu
            document.getElementById('courseModal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            // Recherche côté client simple
            document.getElementById('searchInput').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                document.querySelectorAll('#coursesGrid button.course-card').forEach(card => {
                    const title = card.getAttribute('data-title');
                    if (title.includes(filter)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
