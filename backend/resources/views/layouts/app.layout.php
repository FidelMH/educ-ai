<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduBot - Assistant IA Éducatif')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <!-- Header & Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xl font-bold">🤖</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        EduBot
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <ul class="hidden md:flex items-center gap-8">
                    <li>
                        <a href="{{ route('home') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('chat') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('chat') ? 'text-blue-600' : '' }}">
                            Chat IA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">
                            À propos
                        </a>
                    </li>
                </ul>

                <!-- User Menu -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <!-- Dropdown Profile -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">
                                        {{ substr(auth()->user()->firstname ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-gray-700 font-medium">{{ auth()->user()->firstname ?? 'Utilisateur' }}</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('profile') }}" 
                                   class="flex items-center gap-2 px-4 py-3 hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Mon profil</span>
                                </a>
                                <a href="{{ route('chat.history') }}" 
                                   class="flex items-center gap-2 px-4 py-3 hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Historique</span>
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition">
                            Inscription
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-2 text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-200">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="{{ route('home') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('chat') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition {{ request()->routeIs('chat') ? 'bg-blue-50 text-blue-600' : '' }}">
                            Chat IA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                            À propos
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('profile') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition">
                                Mon profil
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded transition">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" 
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition">
                                Connexion
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" 
                               class="block px-4 py-2 bg-blue-600 text-white text-center rounded transition">
                                Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Flash Messages -->
        <div class="container mx-auto px-4 py-4">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded" role="alert">
                    <p class="font-medium">Succès !</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded" role="alert">
                    <p class="font-medium">Erreur</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <p class="font-medium mb-2">Des erreurs sont survenues :</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">EduBot</h3>
                    <p class="text-gray-400 text-sm">
                        Assistant éducatif intelligent pour accompagner les collégiens et lycéens dans leur apprentissage.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                        <li><a href="{{ route('chat') }}" class="hover:text-white transition">Chat IA</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">À propos</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Aide</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Légal</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition">CGU</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} EduBot - Projet Simplon La Réunion. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>