<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* HEADER */
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

        /* CONTENU PRINCIPAL */
        main.content {
            flex-grow: 1;
            padding: 2rem;
            overflow-y: auto;
        }
    </style>
    @yield('styles')
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
            @yield('content')
        </main>
    </div>
</body>
</html>
