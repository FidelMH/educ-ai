<x-public-layout>
    <!-- Marked.js for Markdown parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked@11.1.1/marked.min.js"></script>

    <style>
        /* Markdown styling */
        .markdown-content h1 { font-size: 1.5rem; font-weight: 700; margin-top: 1rem; margin-bottom: 0.5rem; }
        .markdown-content h2 { font-size: 1.25rem; font-weight: 700; margin-top: 1rem; margin-bottom: 0.5rem; color: #2563eb; }
        .markdown-content h3 { font-size: 1.1rem; font-weight: 600; margin-top: 0.75rem; margin-bottom: 0.5rem; }
        .markdown-content p { margin-bottom: 0.75rem; line-height: 1.6; }
        .markdown-content ul, .markdown-content ol { margin-left: 1.5rem; margin-bottom: 0.75rem; }
        .markdown-content li { margin-bottom: 0.25rem; line-height: 1.5; }
        .markdown-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; font-size: 0.875rem; }
        .markdown-content table th { background-color: #dbeafe; padding: 0.5rem; text-align: left; font-weight: 600; border: 1px solid #93c5fd; }
        .markdown-content table td { padding: 0.5rem; border: 1px solid #e5e7eb; }
        .markdown-content table tr:nth-child(even) { background-color: #f9fafb; }
        .markdown-content code { background-color: #f3f4f6; padding: 0.125rem 0.25rem; border-radius: 0.25rem; font-family: monospace; font-size: 0.875em; }
        .markdown-content pre { background-color: #1f2937; color: #f9fafb; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; margin: 0.75rem 0; }
        .markdown-content pre code { background-color: transparent; padding: 0; color: inherit; }
        .markdown-content blockquote { border-left: 4px solid #2563eb; padding-left: 1rem; margin: 0.75rem 0; color: #4b5563; font-style: italic; }
        .markdown-content strong { font-weight: 700; }
        .markdown-content em { font-style: italic; }
        .markdown-content hr { border: 0; border-top: 2px solid #e5e7eb; margin: 1rem 0; }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex h-[calc(100vh-12rem)]">

                    <!-- Sidebar: Conversations List -->
                    <div class="w-80 border-r border-gray-200 flex flex-col bg-gray-50">
                        <!-- Sidebar Header -->
                        <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                            <button onclick="openNewChatModal()" class="w-full bg-white hover:bg-gray-100 text-blue-600 font-semibold py-2 px-4 rounded-lg flex items-center justify-center space-x-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Nouvelle conversation</span>
                            </button>
                        </div>

                        <!-- Conversations List -->
                        <div class="flex-1 overflow-y-auto">
                            @forelse($discusses as $discuss)
                                <a href="{{ route('chat', $discuss->id) }}"
                                   class="block p-4 border-b border-gray-200 hover:bg-blue-50 transition {{ $activeDiscuss && $activeDiscuss->id === $discuss->id ? 'bg-blue-100 border-l-4 border-l-blue-600' : '' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-gray-800 text-sm truncate">
                                                    {{ $discuss->agent->subject->theme ?? 'Général' }}
                                                </h3>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ $discuss->messages->count() }} message(s)
                                                </p>
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    {{ $discuss->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <form action="{{ route('chat.destroy', $discuss->id) }}" method="POST" class="ml-2" onsubmit="return confirm('Supprimer cette conversation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </a>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">Aucune conversation</p>
                                    <p class="text-xs mt-1">Créez-en une nouvelle</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Main Chat Area -->
                    <div class="flex-1 flex flex-col">
                        @if($activeDiscuss)
                            <!-- Chat Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 border-b border-blue-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-bold text-white">{{ $activeDiscuss->agent->subject->theme ?? 'Educ-AI Assistant' }}</h2>
                                            <p class="text-blue-100 text-sm">Votre assistant d'apprentissage intelligent</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full flex items-center">
                                            <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                            En ligne
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Container -->
                            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
                                @forelse($activeDiscuss->messages as $message)
                                    @if($message->type_message === 'user')
                                        <!-- User Message -->
                                        <div class="flex justify-end">
                                            <div class="max-w-[70%]">
                                                <div class="bg-blue-600 text-white rounded-lg rounded-tr-none shadow-sm p-4">
                                                    <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1 block text-right">{{ $message->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Assistant Message -->
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-white rounded-lg rounded-tl-none shadow-sm p-4 border border-gray-200">
                                                    <div class="text-gray-800 markdown-content" data-markdown>{{ $message->message }}</div>
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <!-- Welcome Message -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-white rounded-lg rounded-tl-none shadow-sm p-4 border border-gray-200">
                                                <p class="text-gray-800">
                                                    Bonjour <span class="font-semibold">{{ Auth::user()->firstname }}</span> ! 👋
                                                </p>
                                                <p class="text-gray-800 mt-2">
                                                    Je suis votre assistant Educ-AI en <strong>{{ $activeDiscuss->agent->subject->theme }}</strong>. Je suis là pour vous aider dans vos études. Posez-moi vos questions !
                                                </p>
                                            </div>
                                            <span class="text-xs text-gray-500 mt-1 block">{{ now()->format('H:i') }}</span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Typing Indicator (hidden by default) -->
                            <div id="typingIndicator" class="px-6 pb-2 hidden">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg rounded-tl-none shadow-sm p-4 border border-gray-200">
                                        <div class="flex space-x-2">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="bg-white border-t border-gray-200 px-6 py-4">
                                <form id="chatForm" class="flex items-end space-x-3">
                                    <div class="flex-1">
                                        <div class="relative">
                                            <textarea
                                                id="messageInput"
                                                rows="1"
                                                placeholder="Tapez votre message ici..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                                style="max-height: 120px; overflow-y: auto;"
                                            ></textarea>
                                        </div>
                                        <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                            <span>Appuyez sur Entrée pour envoyer, Shift+Entrée pour nouvelle ligne</span>
                                            <span id="charCount" class="text-gray-400">0/1000</span>
                                        </div>
                                    </div>
                                    <button
                                        type="submit"
                                        id="sendButton"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <span>Envoyer</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- No Active Conversation - Welcome Screen -->
                            <div class="flex-1 flex flex-col">
                                <!-- Welcome Header -->
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 border-b border-blue-800">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="text-xl font-bold text-white">Educ-AI Assistant</h2>
                                                <p class="text-blue-100 text-sm">Votre assistant d'apprentissage intelligent</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full flex items-center">
                                            <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                            En ligne
                                        </span>
                                    </div>
                                </div>

                                <!-- Welcome Content -->
                                <div class="flex-1 flex items-center justify-center bg-gray-50">
                                    <div class="text-center max-w-md px-4">
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Bienvenue sur Educ-AI ! 👋</h3>
                                        <p class="text-gray-600 mb-6">
                                            Votre assistant d'apprentissage personnel. Sélectionnez une conversation existante ou créez-en une nouvelle pour commencer.
                                        </p>
                                        <button onclick="openNewChatModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-200 inline-flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span>Démarrer une conversation</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Quick Actions (only show when no active discussion) -->
            @if(!$activeDiscuss)
            <div class="mt-4 bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Suggestions de questions :</h3>
                <div class="flex flex-wrap gap-2">
                    <button class="suggestion-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-full transition">
                        Explique-moi les fractions
                    </button>
                    <button class="suggestion-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-full transition">
                        Aide-moi en français
                    </button>
                    <button class="suggestion-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-full transition">
                        Questions d'histoire
                    </button>
                    <button class="suggestion-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-full transition">
                        Sciences physiques
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- New Chat Modal -->
    <div id="newChatModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Choisissez votre assistant</h3>
                        <p class="text-blue-100 text-sm mt-1">Sélectionnez la matière pour laquelle vous souhaitez de l'aide</p>
                    </div>
                    <button type="button" onclick="closeNewChatModal()" class="text-white hover:text-blue-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="p-6 max-h-[calc(85vh-180px)] overflow-y-auto">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($agents as $agent)
                            <label class="group relative cursor-pointer">
                                <input type="radio" name="agent_id" value="{{ $agent->id }}" class="peer sr-only" required>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-4 transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100 peer-checked:shadow-lg hover:shadow-md hover:border-gray-300">
                                    <!-- Icon -->
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <!-- Content -->
                                    <h4 class="font-bold text-gray-900 text-sm mb-2 line-clamp-2">{{ $agent->subject->theme ?? 'Général' }}</h4>
                                    <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($agent->prompt, 50) }}</p>
                                    <!-- Check indicator -->
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 bg-white peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center transition-all">
                                        <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                    <button type="button" onclick="closeNewChatModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                        Annuler
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium shadow-sm transition">
                        Démarrer la conversation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openNewChatModal() {
            document.getElementById('newChatModal').classList.remove('hidden');
        }

        function closeNewChatModal() {
            document.getElementById('newChatModal').classList.add('hidden');
        }

        @if($activeDiscuss)
        // Chat functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Parse existing markdown messages
            document.querySelectorAll('[data-markdown]').forEach(element => {
                const markdownText = element.textContent;
                element.innerHTML = marked.parse(markdownText);
            });

            const messageInput = document.getElementById('messageInput');
            const chatForm = document.getElementById('chatForm');
            const messagesContainer = document.getElementById('messagesContainer');
            const typingIndicator = document.getElementById('typingIndicator');
            const charCount = document.getElementById('charCount');
            const sendButton = document.getElementById('sendButton');
            const discussId = {{ $activeDiscuss->id }};

            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';

                // Update character count
                const length = this.value.length;
                charCount.textContent = `${length}/1000`;

                // Disable send button if empty
                sendButton.disabled = this.value.trim().length === 0;
            });

            // Handle Enter key
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });

            // Handle form submission
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message) return;

                // Disable input
                messageInput.disabled = true;
                sendButton.disabled = true;

                // Add user message
                addMessage(message, 'user');

                // Clear input
                messageInput.value = '';
                messageInput.style.height = 'auto';
                charCount.textContent = '0/1000';

                // Show typing indicator
                typingIndicator.classList.remove('hidden');
                scrollToBottom();

                try {
                    const response = await fetch(`/chat/${discussId}/message`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message: message })
                    });

                    if (!response.ok) throw new Error('Erreur réseau');

                    const data = await response.json();
                    typingIndicator.classList.add('hidden');
                    addMessage(data.message, 'bot');

                } catch (error) {
                    console.error('Error:', error);
                    typingIndicator.classList.add('hidden');
                    addMessage('Désolé, une erreur s\'est produite. Veuillez réessayer.', 'bot');
                } finally {
                    messageInput.disabled = false;
                    sendButton.disabled = false;
                    messageInput.focus();
                }
            });

            // Add message to chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                const currentTime = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

                if (sender === 'user') {
                    messageDiv.className = 'flex justify-end';
                    messageDiv.innerHTML = `
                        <div class="max-w-[70%]">
                            <div class="bg-blue-600 text-white rounded-lg rounded-tr-none shadow-sm p-4">
                                <p class="text-sm leading-relaxed">${escapeHtml(text)}</p>
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block text-right">${currentTime}</span>
                        </div>
                    `;
                } else {
                    messageDiv.className = 'flex items-start space-x-3';
                    // Parse markdown for bot messages
                    const htmlContent = marked.parse(text);
                    messageDiv.innerHTML = `
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg rounded-tl-none shadow-sm p-4 border border-gray-200">
                                <div class="text-gray-800 markdown-content">${htmlContent}</div>
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block">${currentTime}</span>
                        </div>
                    `;
                }

                messagesContainer.appendChild(messageDiv);
                scrollToBottom();
            }

            // Scroll to bottom of messages
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Initial state
            sendButton.disabled = true;
            scrollToBottom();
        });
        @else
        // Handle suggestion buttons when no active discussion
        document.querySelectorAll('.suggestion-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Veuillez d\'abord créer ou sélectionner une conversation pour envoyer un message.');
            });
        });
        @endif
    </script>
</x-public-layout>
