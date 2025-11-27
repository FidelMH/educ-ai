<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Chatbot Educ-AI</h1>

                    <div class="bg-gray-50 rounded-lg p-6 mb-4">
                        <p class="text-gray-700 mb-4">
                            Bienvenue {{ Auth::user()->firstname }} ! Le chatbot sera bientôt disponible ici.
                        </p>
                        <p class="text-gray-600 text-sm">
                            Cette page est en cours de développement. Vous pourrez bientôt discuter avec notre assistant IA
                            pour obtenir de l'aide dans vos études.
                        </p>
                    </div>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <p class="text-gray-500">Interface du chatbot à venir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
