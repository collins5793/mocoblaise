<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Plateforme QCM - Accueil</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }


        nav a {
            position: relative;
            font-size: 1.1em;
            color: #333;
            text-decoration: none;
            padding: 6px 20px;
            transition: .5s;
        }

        nav a:hover {
            color: #0ef;
        }

        nav a span {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            border-bottom: 2px solid #0ef;
            border-radius: 15px;
            transform: scale(0) translateY(50px);
            opacity: 0;
            transition: .5s;
        }

        nav a:hover span {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        /* Custom scrollbar for modern feel */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #4f46e5;
            /* Indigo 600 */
            border-radius: 10px;
        }

        /* Smooth hover transitions */
        a,
        button {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header/Navbar -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700">MoCoBlaise</a>

            <nav class="space-x-6 text-gray-700 font-semibold">
                <a href="#" class="">Accueil</a>
                <a href="#" class="">Cours</a>
                @guest
                    <!-- L'utilisateur n'est PAS connecté -->
                    <a href="{{ route('login') }}" class="">Connexion</a>
                    <a href="{{ route('register') }}" class="">S’inscrire</a>
                @endguest

                @auth
                    <!-- L'utilisateur est connecté -->
                    <a href="{{ route('dashboard') }}" class="">Tableau de bord</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="">Déconnexion</button>
                    </form>
                @endauth
                <span class="ml-4 cursor-pointer select-none">
                    <button id="langFr" class=" font-bold">FR</button> |
                    <button id="langEn" class=" font-bold">EN</button>
                </span>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-24">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col-reverse md:flex-row items-center md:justify-start gap-6">
                <!-- Texte -->
                <div class="text-center md:text-left md:max-w-lg">
                    <h1 class="text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-lg leading-tight">
                        Apprenez, progressez,<br> testez vos connaissances.
                    </h1>
                    <p class="mb-10 text-lg md:text-xl font-medium drop-shadow">
                        Une plateforme QCM complète, interactive et moderne
                    </p>
                    <a href="#"
                        class="inline-block bg-white text-indigo-700 font-bold px-10 py-4 rounded-full shadow-lg hover:bg-gray-200 hover:text-indigo-800 transition">
                        Explorer les cours
                    </a>
                </div>

                <!-- Image -->
                <div class="mb-12 md:mb-0 flex justify-center md:justify-start flex-1 max-w-4xl">
                    <img src="{{ asset('storage/4.jpg') }}" alt="Illustration" class="w-full rounded-lg shadow-xl" />
                </div>
            </div>
        </div>
    </section>

    <!-- Catégories de cours -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="text-4xl font-extrabold text-center mb-16 text-indigo-700">Nos domaines de formation</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @if (!empty($categories))
                    @foreach ($categories as $category)
                        @if ($category !== null)
                            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold">{{ $category['emoji'] }}
                                            {{ $category['name'] }}</h3>
                                        <p class="text-gray-600">{{ $category['count'] }} cours</p>
                                    </div>
                                    <a href="" class="text-blue-600 font-medium hover:underline">Apprendre</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Avantages -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 class="text-4xl font-extrabold mb-14 text-indigo-700">Pourquoi apprendre avec nous ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="p-8 border border-indigo-100 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-7xl mb-6">📘</div>
                    <h3 class="font-bold text-2xl mb-4">Cours Structurés</h3>
                    <p class="text-gray-600 text-lg">Des leçons bien organisées, avec progression claire.</p>
                </div>
                <div class="p-8 border border-indigo-100 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-7xl mb-6">📝</div>
                    <h3 class="font-bold text-2xl mb-4">QCM avec correction</h3>
                    <p class="text-gray-600 text-lg">Chaque QCM propose des corrections détaillées et des
                        justifications.</p>
                </div>
                <div class="p-8 border border-indigo-100 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-7xl mb-6">📜</div>
                    <h3 class="font-bold text-2xl mb-4">Certificats PDF</h3>
                    <p class="text-gray-600 text-lg">Obtenez un certificat téléchargeable après chaque réussite.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 class="text-4xl font-extrabold mb-16 text-indigo-700">Ils nous ont fait confiance</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="text-gray-700 italic text-lg">“Grâce à cette plateforme, j’ai enfin réussi mon concours !”
                    </p>
                    <div class="mt-6 font-semibold text-indigo-700 text-xl">Fatima, Étudiante</div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="text-gray-700 italic text-lg">“Simple, rapide et très complet. Je recommande fortement.”
                    </p>
                    <div class="mt-6 font-semibold text-indigo-700 text-xl">Jean, Candidat libre</div>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md">
                    <p class="text-gray-700 italic text-lg">“Une vraie révolution pour mes élèves en ligne.”</p>
                    <div class="mt-6 font-semibold text-indigo-700 text-xl">Mme Ahoua, Formatrice</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-indigo-900 text-gray-300 py-8">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center max-w-6xl">
            <p class="text-sm">&copy; <span id="year"></span> Plateforme QCM. Tous droits réservés.</p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-sm">
                <a href="#" class="hover:text-white">Mentions légales</a>
                <a href="#" class="hover:text-white">Contact</a>
                <a href="#" class="hover:text-white">Politique de confidentialité</a>
            </div>
        </div>
    </footer>

    <!-- JS pour année dynamique et lang buttons -->
    <script>
        // Dynamically set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();

        // Example for language buttons
        document.getElementById('langFr').addEventListener('click', () => {
            alert('Langue changée en Français (implémenter la logique)');
        });
        document.getElementById('langEn').addEventListener('click', () => {
            alert('Langue changée en Anglais (implémenter la logique)');
        });
    </script>
    <script>
        const isLoggedIn = @json(Auth::check());

        if (!isLoggedIn) {
            document.addEventListener('DOMContentLoaded', () => {
                // Sélectionne tous les liens <a> et boutons <button>
                document.querySelectorAll('a, button').forEach(el => {
                    el.addEventListener('click', e => {
                        // Si le lien a une href et ce n'est pas la page de connexion ou d'inscription,
                        // alors redirige vers login
                        if (el.tagName === 'A') {
                            const href = el.getAttribute('href');
                            if (href && href !== '#' && !href.includes('/login') && !href.includes(
                                    '/register')) {
                                e.preventDefault();
                                window.location.href = "{{ route('login') }}";
                            }
                        }
                        // Pour les boutons, on peut aussi rediriger
                        else if (el.tagName === 'BUTTON') {
                            e.preventDefault();
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                });
            });
        }
    </script>

</body>

</html>
