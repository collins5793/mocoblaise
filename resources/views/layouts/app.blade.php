<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'MoCoblaise') }}</title>

    <!-- Styles stack -->
    @stack('styles')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom colors & styles -->
    <style>
        /* Orange clair translucide pour header */
        .bg-orange-light {
            background-color: #fcdcbccc;
        }

        /* Pour rendre header sticky */
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Ombre subtile pour header */
        .shadow-soft {
            box-shadow: 0 2px 6px rgba(252, 220, 220, 0.6);
        }

        /* Soulignement animé pour les liens du menu */
        nav a {
            position: relative;
            padding-bottom: 0.25rem;
            transition: color 0.3s ease;
        }

        nav a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background-color: #4f46e5;
            /* Indigo 600 */
            border-radius: 10px;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        nav a:hover {
            color: #4f46e5;
        }

        nav a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased text-gray-800 dark:text-gray-200">

    <!-- Header -->
    <header class="bg-orange-light shadow-soft text-gray-900 dark:text-gray-900 py-5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
            <h1 class="text-3xl font-extrabold tracking-tight mb-4 md:mb-0 cursor-default">{{ config('app.name') }}</h1>

            <nav class="space-x-6 text-gray-900 font-semibold text-lg">
                <a href="{{ route('home') }}" class="">Accueil</a>
                <a href="{{ route('courses.all') }}" class="">Cours</a>

                @guest
                    <a href="{{ route('login') }}" class="">Connexion</a>
                    <a href="{{ route('register') }}" class="">S’inscrire</a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="">Tableau de bord</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 hover:underline cursor-pointer">
                            Se déconnecter
                        </a>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-6 py-12 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer
        class="bg-gray-200 dark:bg-gray-800 border-t border-gray-300 dark:border-gray-700 mt-16 text-center py-6 text-sm text-gray-700 dark:text-gray-400 select-none">
        © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
    </footer>

    <!-- Scripts stack -->
    @stack('scripts')
</body>

</html>
