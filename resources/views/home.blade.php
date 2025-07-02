@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <section
        class="relative bg-gradient-to-r from-orange-200 via-orange-100 to-orange-100 text-gray-900 py-28 overflow-hidden rounded-2xl shadow-lg">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <img src="https://www.transparenttextures.com/patterns/cubes.png" class="w-full h-full object-cover" />
        </div>
        <div class="relative container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col-reverse md:flex-row items-center md:justify-start gap-10">
                <div class="text-center md:text-left md:max-w-lg">
                    <h1 class="text-5xl md:text-7xl font-extrabold mb-8 drop-shadow-md leading-tight">
                        Apprenez, progressez,<br> testez vos connaissances.
                    </h1>
                    <p class="mb-12 text-lg md:text-2xl font-medium drop-shadow-sm max-w-md">
                        Une plateforme QCM complète, interactive et moderne
                    </p>
                    <a href="{{ route('courses.all') }}"
                        class="inline-block bg-white text-orange-600 font-extrabold px-12 py-4 rounded-full shadow-xl hover:bg-orange-100 hover:text-orange-700 transition transform hover:scale-105 ring-2 ring-orange-200">
                        Explorer les cours
                    </a>
                </div>
                <div class="mb-12 md:mb-0 flex justify-center md:justify-start flex-1 max-w-4xl">
                    <img src="{{ asset('storage/4.jpg') }}" alt="Illustration"
                        class="w-full rounded-2xl shadow-2xl border border-orange-200" />
                </div>
            </div>
        </div>
    </section>

    <!-- Catégories -->
    <section class="py-24 bg-gray-100 dark:bg-gray-800">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2
                class="text-4xl font-extrabold text-center mb-20 text-indigo-700 dark:text-indigo-400 tracking-wide uppercase">
                Nos domaines de formation
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @if (!empty($categories))
                    @foreach ($categories as $category)
                        @if ($category !== null)
                            <div
                                class="bg-orange-50 dark:bg-orange-100 p-8 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $category['emoji'] }}
                                            {{ $category['name'] }}</h3>
                                        <p class="text-gray-700 mt-1">{{ $category['count'] }} cours</p>
                                    </div>
                                    <a href="{{ route('courses.byCategory', ['category' => $category['name']]) }}"
                                        class="text-orange-600 font-semibold hover:text-orange-800 hover:underline transition">
                                        Apprendre
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Avantages -->
    <section class="py-24 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 class="text-4xl font-extrabold mb-16 text-indigo-700 dark:text-indigo-400 tracking-wide uppercase">
                Pourquoi apprendre avec nous ?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-14">
                <div class="p-10 bg-orange-50 rounded-2xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-8xl mb-8 animate-bounce">📘</div>
                    <h3 class="font-bold text-3xl mb-6 text-gray-800">Cours Structurés</h3>
                    <p class="text-gray-700 text-lg max-w-md mx-auto">Des leçons bien organisées, avec progression claire.
                    </p>
                </div>
                <div class="p-10 bg-orange-50 rounded-2xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-8xl mb-8 animate-pulse">📝</div>
                    <h3 class="font-bold text-3xl mb-6 text-gray-800">QCM avec correction</h3>
                    <p class="text-gray-700 text-lg max-w-md mx-auto">Chaque QCM propose des corrections détaillées et
                        des justifications.</p>
                </div>
                <div class="p-10 bg-orange-50 rounded-2xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-8xl mb-8 animate-spin-slow">📜</div>
                    <h3 class="font-bold text-3xl mb-6 text-gray-800">Certificats PDF</h3>
                    <p class="text-gray-700 text-lg max-w-md mx-auto">Obtenez un certificat téléchargeable après chaque
                        réussite.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages -->
    <section class="py-24 bg-gray-100 dark:bg-gray-800">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <h2 class="text-4xl font-extrabold mb-20 text-indigo-700 dark:text-indigo-400 tracking-wide uppercase">
                Ils nous ont fait confiance
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-14">
                <div class="bg-orange-50 p-10 rounded-2xl shadow-md hover:shadow-lg transition max-w-md mx-auto">
                    <p class="text-gray-700 italic text-lg leading-relaxed">“Grâce à cette plateforme, j’ai enfin réussi mon
                        concours !”</p>
                    <div class="mt-8 font-semibold text-indigo-700 text-xl">Fatima, Étudiante</div>
                </div>
                <div class="bg-orange-50 p-10 rounded-2xl shadow-md hover:shadow-lg transition max-w-md mx-auto">
                    <p class="text-gray-700 italic text-lg leading-relaxed">“Simple, rapide et très complet. Je recommande
                        fortement.”</p>
                    <div class="mt-8 font-semibold text-indigo-700 text-xl">Jean, Candidat libre</div>
                </div>
                <div class="bg-orange-50 p-10 rounded-2xl shadow-md hover:shadow-lg transition max-w-md mx-auto">
                    <p class="text-gray-700 italic text-lg leading-relaxed">“Une vraie révolution pour mes élèves en ligne.”
                    </p>
                    <div class="mt-8 font-semibold text-indigo-700 text-xl">Mme Ahoua, Formatrice</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }
    </style>
@endpush
