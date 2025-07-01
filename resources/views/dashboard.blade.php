<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Utilisateur</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #1e293b;
      color: white;
      padding-top: 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      width: 100%;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #2563eb;
      color: white;
    }
    .content {
      margin-left: 240px;
      padding: 2rem;
      max-width: 900px;
      margin-right: auto;
    }
    section {
      margin-bottom: 3rem;
    }
    .progress-bar {
      background-color: #2563eb !important;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <div class="mb-4">
  <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
    <i class="bi bi-house-door-fill"></i> Accueil
  </a>
</div>

    <a href="#profil">👤 Profil</a>
    <a href="#progression">📊 Progression</a>
    <a href="#quizzes">📝 Mes Quiz</a>
    <a href="#cours">📚 Mes Cours</a>
    <a href="#certificats">🏅 Certificats</a>
  </div>

  <main class="content">

    {{-- Messages flash --}}
    @foreach (['success', 'error', 'message'] as $msg)
      @if(session($msg))
        @php
          $alertClass = match($msg) {
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'message' => 'alert-info',
            default => 'alert-primary'
          };
        @endphp
        <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
          {{ session($msg) }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
      @endif
    @endforeach

    <section id="profil">
      <h2>👤 Profil</h2>
      <p><strong>Nom:</strong> {{ Auth::user()->name }}</p>
      <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier mon profil</a>
      <hr>
    </section>



    <section id="progression">
      <h2>📊 Ma progression</h2>
      <div class="row mb-4">
        <div class="col-sm-6 col-lg-3">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5>Cours suivis</h5>
              <p class="fs-3 fw-bold">{{ $totalCourses }}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5>Leçons vues</h5>
              <p class="fs-3 fw-bold">{{ $totalLessonsViewed }}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mt-3 mt-lg-0">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5>Quiz faits</h5>
              <p class="fs-3 fw-bold">{{ $totalQuizzesDone }}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mt-3 mt-lg-0">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5>Moyenne globale</h5>
              <p class="fs-3 fw-bold">{{ $averageScore }}%</p>
            </div>
          </div>
        </div>
      </div>

      <h4>Progression par cours</h4>
      <canvas id="progressChart" height="150"></canvas>
      <hr>
    </section>

    <section id="quizzes">
      <h2>📝 Mes Quiz</h2>

      <canvas id="quizPieChart" height="150" class="mb-4"></canvas>

      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>Quiz</th>
            <th>Date</th>
            <th>Score</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($quizAttempts as $attempt)
            <tr>
              <td>{{ $attempt->quiz->title }}</td>
              <td>{{ $attempt->attempted_at->format('d/m/Y') }}</td>
              <td>{{ $attempt->score }}%</td>
              <td>
                @if($attempt->passed)
                  <span class="badge bg-success">Réussi</span>
                @else
                  <span class="badge bg-danger">Échoué</span>
                @endif
              </td>
              <td><a href="#" class="btn btn-sm btn-info">Voir la correction</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <hr>
    </section>

    <section id="cours">
      <h2>📚 Mes Cours</h2>
      <h5 class="text-warning">🟡 En cours</h5>
      @foreach ($coursesInProgress as $course)
        <div class="mb-3 p-3 border rounded shadow-sm">
          <strong>{{ $course['title'] }}</strong><br>
          Dernier chapitre: {{ $course['last_lesson'] }}<br>
          <div class="progress my-2">
            <div class="progress-bar" style="width: {{ $course['progress'] }}%">{{ $course['progress'] }}%</div>
          </div>
          <a href="{{ $course['continue_url'] }}" class="btn btn-sm btn-primary">Continuer ce cours</a>
        </div>
      @endforeach

      <h5 class="mt-4 text-success">✅ Cours Terminés</h5>
      @foreach ($completedCourses as $course)
        <div class="mb-3 p-3 border rounded shadow-sm d-flex align-items-center justify-content-between">
          <div><strong>{{ $course['title'] }}</strong></div>

          @php
              $existingCert = \App\Models\Certificate::where('user_id', Auth::id())
                                ->where('course_id', $course['id'])->first();
          @endphp

          <div>
            @if ($existingCert)
              <a href="{{ route('certificates.download', ['course' => $course['id']]) }}" class="btn btn-outline-success btn-sm">
                📥 Télécharger le certificat
              </a>
            @else
              <a href="{{ route('certificates.generate', ['course' => $course['id']]) }}" class="btn btn-success btn-sm">
                🎓 Obtenir mon certificat
              </a>
            @endif
          </div>
        </div>
      @endforeach
      <hr>
    </section>

    <section id="certificats">
      <h2>🏅 Mes Certificats</h2>
      @forelse ($certificates as $cert)
        <div class="mb-3 p-3 border rounded shadow-sm d-flex justify-content-between align-items-center">
          <div><strong>{{ $cert['course_title'] }}</strong> | Obtenu le {{ $cert['date'] }}</div>
          <a href="{{ $cert['download_url'] }}" class="btn btn-outline-secondary btn-sm">
            📥 Télécharger le PDF
          </a>
        </div>
      @empty
        <p>Vous n’avez encore aucun certificat.</p>
      @endforelse
      <hr>
    </section>

    
  </main>

  <!-- Bootstrap JS + Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Chart.js scripts -->
  <script>
    // Données pour la progression par cours (Bar Chart)
    const courseLabels = {!! json_encode(array_column($courseProgress, 'title')) !!};
    const courseProgressData = {!! json_encode(array_column($courseProgress, 'progress')) !!};

    const ctxProgress = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctxProgress, {
      type: 'bar',
      data: {
        labels: courseLabels,
        datasets: [{
          label: 'Progression (%)',
          data: courseProgressData,
          backgroundColor: '#2563eb',
          borderRadius: 5
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: { stepSize: 10 }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: { enabled: true }
        }
      }
    });

    // Données pour le Pie Chart des quiz réussis/échoués
    const quizPassedCount = {{ $quizAttempts->where('passed', true)->count() }};
    const quizFailedCount = {{ $quizAttempts->where('passed', false)->count() }};

    const ctxPie = document.getElementById('quizPieChart').getContext('2d');
    const quizPieChart = new Chart(ctxPie, {
      type: 'pie',
      data: {
        labels: ['Réussis', 'Échoués'],
        datasets: [{
          data: [quizPassedCount, quizFailedCount],
          backgroundColor: ['#198754', '#dc3545'],
          hoverOffset: 20
        }]
      },
      options: {
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  </script>

</body>
</html>
