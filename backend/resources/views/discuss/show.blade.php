<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Discussion #') . $discuss->id }}
                </h2>
                <p class="text-sm text-gray-500">
                    Agent: {{ $discuss->agent->subject->theme ?? 'Général' }} (ID: {{ $discuss->agent->id }})
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('discuss.edit', $discuss) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Modifier Agent
                </a>
                <a href="{{ route('discuss.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Conteneur du Chat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 flex flex-col h-[600px]">
                
                <!-- Zone des messages -->
                <div class="flex-1 p-6 overflow-y-auto bg-gray-50 space-y-6" id="messages-container">
                    @forelse($discuss->messages as $message)
                        <!-- Message -->
                        <div class="flex w-full {{ $message->is_user ? 'justify-end' : 'justify-start' }}">
                            <div class="flex flex-col space-y-1 max-w-[70%]">
                                <div class="px-4 py-3 rounded-lg shadow-sm text-sm leading-relaxed {{ $message->is_user ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none' }}">
                                    {{ $message->content }}
                                </div>
                                <span class="text-xs text-gray-400 {{ $message->is_user ? 'text-right' : 'text-left' }}">
                                    {{ $message->is_user ? 'Vous' : 'Agent' }} • {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-lg">Aucun message pour l'instant.</p>
                            <p class="text-sm">Envoyez le premier message pour démarrer la simulation.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Zone de saisie (Footer) -->
                <div class="p-4 bg-white border-t border-gray-200">
                    <!-- Assure-toi d'avoir la route 'messages.store' définie -->
                    <form action="{{ route('messages.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="hidden" name="discuss_id" value="{{ $discuss->id }}">
                        
                        <input type="text" name="content" 
                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-3 px-4" 
                               placeholder="Écrivez votre message ici..." 
                               autocomplete="off"
                               required>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-150 ease-in-out flex items-center gap-2">
                            <span>Envoyer</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Script pour scroller automatiquement vers le bas -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('messages-container');
            if(container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>