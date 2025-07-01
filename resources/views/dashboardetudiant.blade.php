<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Utilisateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html {
      scroll-behavior: smooth;
    }
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
    }
    .dashboard-container {
      display: flex;
      flex-direction: row-reverse;
    }
    .sidebar {
      width: 200px;
      background-color: #1e293b;
      color: white;
      position: sticky;
      top: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding-top: 2rem;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      margin: 10px 0;
      display: block;
    }
    .content {
      flex: 1;
      padding: 2rem;
    }
    .progress-bar {
      background-color: #2563eb;
    }
  </style>
</head>
<body>
<div class="dashboard-container">
  <div class="sidebar">
    <a href="#profil">👤 Profil</a>
    <a href="#progression">📊 Progression</a>
    <a href="#quizzes">📝 Mes Quiz</a>
    <a href="#cours">📚 Mes Cours</a>
    <a href="#certificats">🏅 Certificats</a>
    <a href="#notifications">🔔 Notifications</a>
  </div>

  <div class="content">
    <section id="profil">
      <h2>👤 Profil</h2>
      <p>Nom: {{ Auth::user()->name }}</p>
      <p>Email: {{ Auth::user()->email }}</p>
      <p>Rôle: Étudiant</p>
      <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier mon profil</a>
      <hr>
    </section>

    <section id="progression">
      <h2>📊 Ma progression</h2>
      <p>Cours suivis: {{ $totalCourses }}</p>
      <p>Leçons vues: {{ $totalLessonsViewed }}</p>
      <p>Quiz faits: {{ $totalQuizzesDone }}</p>
      <p>Moyenne globale: {{ $averageScore }}%</p>

      <h4>Progression par cours</h4>
      @foreach ($courseProgress as $course)
        <div class="mb-3">
          <strong>{{ $course['title'] }}</strong>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $course['progress'] }}%">{{ $course['progress'] }}%</div>
          </div>
        </div>
      @endforeach
      <hr>
    </section>

    <section id="quizzes">
      <h2>📝 Mes Quiz</h2>
      <table class="table">
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
              <td>{{ $attempt->passed ? 'Réussi' : 'Échoué' }}</td>
              <td><a href="#" class="btn btn-sm btn-info">Voir la correction</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <hr>
    </section>

    <section id="cours">
      <h2>📚 Mes Cours</h2>
      <h5>🟡 En cours</h5>
      @foreach ($coursesInProgress as $course)
        <div>
          <strong>{{ $course['title'] }}</strong><br>
          Dernier chapitre: {{ $course['last_lesson'] }}<br>
          <div class="progress mb-2">
            <div class="progress-bar" style="width: {{ $course['progress'] }}%">{{ $course['progress'] }}%</div>
          </div>
          <a href="{{ $course['continue_url'] }}" class="btn btn-sm btn-primary">Continuer ce cours</a>
        </div>
      @endforeach

      <h5 class="mt-4">✅ Terminés</h5>
      @foreach ($completedCourses as $course)
        <div>
          <strong>{{ $course['title'] }}</strong>
          <a href="{{ $course['certificate_url'] }}" class="btn btn-success btn-sm">Obtenir mon certificat</a>
        </div>
      @endforeach
      <hr>
    </section>

    <section id="certificats">
      <h2>🏅 Mes Certificats</h2>
      @foreach ($certificates as $cert)
        <div>
          <p>Cours: {{ $cert['course_title'] }} | Obtenu le {{ $cert['date'] }}</p>
          <a href="{{ $cert['download_url'] }}" class="btn btn-outline-secondary btn-sm">Télécharger PDF</a>
        </div>
      @endforeach
      <hr>
    </section>

    <section id="notifications">
      <h2>🔔 Notifications</h2>
      <ul>
        @foreach ($notifications as $note)
          <li>{{ $note }}</li>
        @endforeach
      </ul>
    </section>
  </div>
</div>
</body>
</html>
