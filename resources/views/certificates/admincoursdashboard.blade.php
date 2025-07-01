<!-- Tableau des cours avec vue hiérarchique et boutons d'ajout -->

<div class="container mt-5">
  <h2 class="text-center mb-4">Liste des Cours</h2>

  <div class="accordion" id="coursAccordion">
    @foreach($courses as $course)
      <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="heading-{{ $course->id }}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $course->id }}" aria-expanded="false" aria-controls="collapse-{{ $course->id }}">
            📘 {{ $course->title }}
          </button>
        </h2>
        <div id="collapse-{{ $course->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $course->id }}" data-bs-parent="#coursAccordion">
          <div class="accordion-body">
            <!-- Bouton pour ajouter une leçon -->
            <div class="d-flex justify-content-between mb-2">
              <strong>Leçons du cours :</strong>
              <a href="{{ route('lessons.create', $course->id) }}" class="btn btn-sm btn-success">+ Ajouter une leçon</a>
            </div>

            @foreach($course->lessons as $lesson)
              <div class="card mb-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <span>📖 {{ $lesson->title }}</span>
                  <!-- Bouton pour ajouter un quiz à cette leçon -->
                  <a href="{{ route('quizzes.create', $lesson->id) }}" class="btn btn-sm btn-primary">+ Ajouter un quiz</a>
                </div>
                <div class="card-body">
                  @if($lesson->quizzes->count())
                    <ul class="list-group">
                      @foreach($lesson->quizzes as $quiz)
                        <li class="list-group-item">📝 {{ $quiz->title }}</li>
                      @endforeach
                    </ul>
                  @else
                    <p class="text-muted">Aucun quiz pour cette leçon.</p>
                  @endif
                </div>
              </div>
            @endforeach

            @if($course->lessons->isEmpty())
              <p class="text-muted">Ce cours n'a pas encore de leçons.</p>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Bouton général pour ajouter un nouveau cours -->
  <div class="text-center mt-4">
    <a href="{{ route('courses.create') }}" class="btn btn-lg btn-outline-primary">➕ Ajouter un nouveau cours</a>
  </div>
</div>

<!-- Pense à bien inclure Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
