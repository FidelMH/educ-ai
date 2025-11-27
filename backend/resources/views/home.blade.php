<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-bold mb-6">Bienvenue sur Educ-AI</h1>

                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4">À propos du projet</h2>
                        <p class="text-lg text-gray-700 mb-4">
                            Educ-AI est une plateforme éducative innovante qui utilise l'intelligence artificielle
                            pour accompagner les étudiants dans leur apprentissage.
                        </p>
                        <p class="text-lg text-gray-700">
                            Notre chatbot intelligent est conçu pour répondre à vos questions,
                            vous guider dans vos études et vous aider à progresser dans différentes matières.
                        </p>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold mb-4">Fonctionnalités</h2>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>Chatbot éducatif intelligent disponible 24/7</li>
                            <li>Support personnalisé selon votre niveau d'études</li>
                            <li>Assistance dans plusieurs matières</li>
                            <li>Suivi de vos discussions et de votre progression</li>
                        </ul>
                    </div>

                    @guest
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <p class="text-lg text-gray-700 mb-4">
                                Pour accéder au chatbot et profiter de toutes les fonctionnalités,
                                veuillez vous connecter ou créer un compte.
                            </p>
                            <div class="flex gap-4">
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Se connecter
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    S'inscrire
                                </a>
                            </div>
                        </div>
                    @endguest

                    @auth
                        <div class="mt-8 p-4 bg-green-50 rounded-lg">
                            <p class="text-lg text-gray-700 mb-4">
                                Vous êtes connecté ! Accédez au chatbot pour commencer votre session d'apprentissage.
                            </p>
                            <a href="/chat" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Accéder au Chat
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-public-layout>