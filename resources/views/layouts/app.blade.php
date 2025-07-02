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
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased text-gray-800 dark:text-gray-200">

    <!-- Header -->
    <header class="bg-orange-light shadow-soft text-gray-900 dark:text-gray-900 text-center py-5">
        <h1 class="text-3xl font-extrabold tracking-tight">{{ config('app.name') }}</h1>
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
