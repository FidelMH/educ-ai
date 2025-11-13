@extends('layouts.app')

@section('title', 'Accueil - EduBot')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Bienvenue sur EduBot 🤖
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Ton assistant éducatif intelligent pour réussir au collège et au lycée
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('chat') }}" 
                   class="px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
                    Commencer à discuter 💬
                </a>
                @guest
                    <a href="{{ route('register') }}" 
                       class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-bold text-lg hover:bg-white hover:text-blue-600 transition">
                        Créer un compte gratuit
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Pourquoi choisir EduBot ?
            </h2>
            <p class="text-xl text-gray-600">
                Un assistant personnalisé qui s'adapte à ton niveau et tes besoins
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Toutes les matières</h3>
                <p class="text-gray-600">
                    Mathématiques, Français, SVT, Physique, Histoire... Des agents spécialisés pour chaque matière.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl hover:shadow-lg transition">
                <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Adapté à ton niveau</h3>
                <p class="text-gray-600">
                    Que tu sois en 6ème ou en Terminale, l'assistant s'adapte à ton niveau scolaire.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-8 rounded-2xl hover:shadow-lg transition">
                <div class="w-16 h-16 bg-pink-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Disponible 24/7</h3>
                <p class="text-gray-600">
                    Pose tes questions à n'importe quel moment, l'assistant est toujours là pour t'aider.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Comment ça marche ?
            </h2>
            <p class="text-xl text-gray-600">
                3 étapes simples pour commencer à apprendre
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">
                    1
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Choisis ta matière</h3>
                <p class="text-gray-600">
                    Sélectionne la matière dans laquelle tu as besoin d'aide
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">
                    2
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Indique ton niveau</h3>
                <p class="text-gray-600">
                    Précise ton niveau scolaire pour un accompagnement personnalisé
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-pink-600 text-white rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">
                    3
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pose tes questions</h3>
                <p class="text-gray-600">
                    Discute avec ton assistant et obtiens des explications claires
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            Prêt à améliorer tes résultats ?
        </h2>
        <p class="text-xl mb-8 text-blue-100">
            Rejoins des centaines d'élèves qui progressent grâce à EduBot
        </p>
        <a href="{{ route('register') }}" 
           class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition">
            Créer mon compte gratuitement 🚀
        </a>
    </div>
</section>
@endsection