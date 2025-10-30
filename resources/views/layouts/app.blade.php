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
<body class="font-sans antialiased text-gray-800">
	<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 shadow-lg">
               	<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                   	<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                       	<div>
                           	<h3 class="text-lg font-semibold text-gray-800 mb-4">Agri-Platform Sénégal</h3>
                           	<p class="text-sm text-gray-600">Connectez-vous avec l'agriculture moderne du Sénégal.</p>
                       	</div>
                       	<div>
                           	<h4 class="text-sm font-semibold text-gray-800 mb-4">Liens utiles</h4>
                           	<ul class="space-y-2 text-sm text-gray-600">
                           	   	<li><a href="{{ route('about') }}" class="hover:text-green-600 transition-colors">À propos</a></li>
                           	   	<li><a href="{{ route('contact') }}" class="hover:text-green-600 transition-colors">Contact</a></li>
                           	   	<li><a href="{{ route('support') }}" class="hover:text-green-600 transition-colors">Support</a></li>
                           	</ul>
                       	</div>
                       	<div>
                           	<h4 class="text-sm font-semibold text-gray-800 mb-4">Suivez-nous</h4>
                           	<div class="flex space-x-4">
                               	<a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                                   	<span class="text-xl">📘</span>
                               	</a>
                               	<a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                                   	<span class="text-xl">🐦</span>
                               	</a>
                               	<a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                                   	<span class="text-xl">📷</span>
                               	</a>
                           	</div>
                       	</div>
                   	</div>
                   	<div class="border-t mt-8 pt-6 text-center text-sm text-gray-600">
                       	<p>© {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés</p>
                   	</div>
               	</div>
            </footer>
        </div>
    </body>
</html>
