<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Plateforme QCM</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* CSS intégré - style moderne et propre */

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
            background-color: #f4f6f8;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        header a.logout-btn {
            color: white;
            text-decoration: none;
            font-weight: 600;
            border: 1.5px solid white;
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        header a.logout-btn:hover {
            background-color: white;
            color: #007bff;
        }

        /* LAYOUT PRINCIPAL */
        .container {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f8;
        }

        /* SIDEBAR */
        nav.sidebar {
            width: 220px;
            background-color: #0d6efd;
            color: white;
            padding-top: 2rem;
            display: flex;
            flex-direction: column;
        }

        nav.sidebar a {
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            font-weight: 600;
            border-left: 4px solid transparent;
            transition: background-color 0.2s ease, border-left-color 0.2s ease;
        }

        nav.sidebar a:hover,
        nav.sidebar a.active {
            background-color: #0056b3;
            border-left-color: #ffc107;
        }

        main.content {
            flex-grow: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        h2 {
            margin-top: 0;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.3rem;
            margin-bottom: 1.2rem;
        }

        /* Statistiques utilisateurs */
        .stats-utilisateurs {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .stats-utilisateurs div {
            background-color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgb(0 0 0 / 0.1);
            flex: 1;
            text-align: center;
        }

        .stats-utilisateurs div strong {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 0.3rem;
            color: #333;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgb(0 0 0 / 0.1);
            margin-bottom: 2rem;
        }

        th, td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 0.95rem;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }

        tbody tr:hover {
            background-color: #f1f5fb;
        }

        /* Accordéon Cours */
        .course-item {
            background-color: white;
            border-radius: 10px;
            margin-bottom: 1rem;
            padding: 1rem 1.5rem;
            box-shadow: 0 3px 8px rgb(0 0 0 / 0.05);
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #004085;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .course-actions a {
            color: #007bff;
            text-decoration: none;
            margin-left: 1rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .course-actions a:hover {
            text-decoration: underline;
        }

        .lessons-list {
            margin-top: 0.8rem;
            margin-left: 1rem;
        }

        .lesson-item {
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #0b5ed7;
            cursor: default;
        }

        .quizzes-list {
            margin-left: 1.5rem;
            font-weight: 400;
            color: #495057;
        }

        /* Boutons */
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }
            nav.sidebar {
                width: 100%;
                display: flex;
                flex-direction: row;
                overflow-x: auto;
            }
            nav.sidebar a {
                flex: 1 0 auto;
                text-align: center;
                border-left: none;
                border-bottom: 4px solid transparent;
            }
            nav.sidebar a.active,
            nav.sidebar a:hover {
                border-left: none;
                border-bottom-color: #ffc107;
            }
        }
    </style>
</head>
<body>

<header>
        <h1>Admin Dashboard</h1>
        <span>Admin : {{ auth()->user()->name }}</span>
        <a href="{{ route('logout') }}" class="logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </header>

    <div class="container">
        <nav class="sidebar">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
  <i class="bi bi-arrow-left-circle"></i> Accueil
</a>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👥 Utilisateurs</a>
    
    <!-- Cours -->
    <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">📚 Cours</a>
    
    <!-- Leçons -->
    <a href="{{ route('lessons.all') }}" class="{{ request()->routeIs('lessons.all') ? 'active' : '' }}">📖 Leçons</a>
    
    <!-- Quiz -->
    <a href="{{ route('quizzes.index') }}" class="{{ request()->routeIs('quizzes.*') ? 'active' : '' }}">❓ Quiz</a>
    
    <!-- Certificats -->
    <a href="{{ route('admin.certificates.index') }}" class="{{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">🎓 Certificats</a>
    
    <!-- Statistiques -->
    <a href="{{ route('admin.statistics.index') }}" class="{{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">📈 Statistiques</a>
    
    <!-- Paramètres -->
</nav>

    <main class="content">
        {{-- Section Utilisateurs --}}
        <section id="utilisateurs">
            <h2>Utilisateurs</h2>

            <div class="stats-utilisateurs">
                <div>
                    <strong>{{ $totalUsers }}</strong>
                    Total utilisateurs
                </div>
                <div>
                    <strong>{{ $totalAdmins }}</strong>
                    Administrateurs
                </div>
                <div>
                    <strong>{{ $totalStudents }}</strong>
                    Étudiants
                </div>
            </div>

            <h3>Derniers utilisateurs inscrits</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Inscriptions utilisateurs par mois</h3>
            <canvas id="chartUsersInscriptions" height="120"></canvas>
        </section>

        {{-- Section Cours --}}
        <section id="cours">
            <h2>Cours</h2>

            <p><strong>Total cours :</strong> {{ $totalCourses }}</p>

            @foreach($courses as $course)
                <div class="course-item">
                    <div class="course-title" onclick="toggleLessons('lessons-{{ $course->id }}')">
                        {{ $course->title }}
                        <span class="course-actions">
                            <a href="">Modifier</a> |
                            <a href=""
                               onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </span>
                    </div>
                    <div id="lessons-{{ $course->id }}" class="lessons-list" style="display:none;">
                        @foreach($course->lessons as $lesson)
                            <div class="lesson-item">
                                Leçon : {{ $lesson->title }}
                                <ul class="quizzes-list">
                                    @foreach($lesson->quizzes as $quiz)
                                        <li>Quiz : {{ $quiz->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>

        {{-- Section Certificats --}}
        <section id="certificats">
            <h2>Certificats</h2>

            <p><strong>Total certificats délivrés :</strong> {{ $totalCertificates }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Cours</th>
                        <th>Date délivrance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $cert)
                        <tr>
                            <td>{{ $cert->user->name }}</td>
                            <td>{{ $cert->course->title }}</td>
                            <td>{{ $cert->generated_at?->format('d/m/Y') ?? 'Non défini' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </section>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle affichage des leçons d'un cours
    function toggleLessons(id) {
        const elem = document.getElementById(id);
        if (!elem) return;
        if (elem.style.display === 'none' || elem.style.display === '') {
            elem.style.display = 'block';
        } else {
            elem.style.display = 'none';
        }
    }

    // Chart inscriptions utilisateurs par mois
    const ctxUsers = document.getElementById('chartUsersInscriptions').getContext('2d');
    const chartUsersInscriptions = new Chart(ctxUsers, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Inscriptions utilisateurs',
                data: {!! json_encode($usersPerMonth) !!},
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#007bff',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>

</body>
</html>
