<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer style="text-align:center; padding:1.5rem; background:#f4f6f4;">
                <div style="display:flex; justify-content:center; gap:1.5rem; flex-wrap:wrap; margin-bottom:0.75rem;">
                    <a href="{{ route('home') }}" style="color:#4b5563; text-decoration:none; font-size:0.85rem;">Accueil</a>
                    <a href="{{ route('contact') }}" style="color:#4b5563; text-decoration:none; font-size:0.85rem;">Contact</a>
                    <a href="{{ route('mentions-legales') }}" style="color:#4b5563; text-decoration:none; font-size:0.85rem;">Mentions légales</a>
                    <a href="{{ route('confidentialite') }}" style="color:#4b5563; text-decoration:none; font-size:0.85rem;">Politique de confidentialité</a>
                </div>
                <div style="color:#9ca3af; font-size:0.8rem;">© 2026 Zero Gaspi — Ensemble, réduisons le gaspillage alimentaire.</div>
            </footer>
        </div>

        @include('layouts.cookie-consent')
    </body>
</html>