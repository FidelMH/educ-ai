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

        /* Scrollbar personnalisé */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Animation d'apparition */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .message-animation { animation: slideIn 0.3s ease-out; }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto h-screen flex flex-col">

            @if(session('success'))
                <div class="mx-4 mt-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-r shadow-sm" role="alert" aria-live="polite">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex-1 flex overflow-hidden m-4 bg-white rounded-2xl shadow-xl">

                <!-- Sidebar: Liste des conversations -->
                <aside class="w-80 border-r border-slate-200 flex flex-col bg-slate-50" aria-label="Liste des conversations">
                    <!-- Sidebar Header -->
                    <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <button
                            onclick="openNewChatModal()"
                            class="w-full bg-white hover:bg-slate-50 text-blue-600 font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            aria-label="Créer une nouvelle conversation">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Nouvelle conversation</span>
                        </button>
                    </div>

                    <!-- Conversations List -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($discusses as $discuss)
                            <a href="{{ route('chat', $discuss->id) }}"
                               class="block p-4 border-b border-slate-200 hover:bg-blue-50 transition-colors duration-200 {{ $activeDiscuss && $activeDiscuss->id === $discuss->id ? 'bg-blue-100 border-l-4 border-l-blue-600' : '' }}"
                               aria-label="Conversation sur {{ $discuss->agent->subject->theme ?? 'Général' }}"
                               aria-current="{{ $activeDiscuss && $activeDiscuss->id === $discuss->id ? 'page' : 'false' }}">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm" aria-hidden="true">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-slate-800 text-sm truncate">
                                                {{ $discuss->agent->subject->theme ?? 'Général' }}
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $discuss->messages->count() }} message(s)
                                            </p>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ $discuss->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <form action="{{ route('chat.destroy', $discuss->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette conversation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors p-1 rounded focus:outline-none focus:ring-2 focus:ring-red-500" aria-label="Supprimer la conversation">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-slate-500">
                                <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="font-medium">Aucune conversation</p>
                                <p class="text-sm mt-1">Créez-en une nouvelle pour commencer</p>
                            </div>
                        @endforelse
                    </div>
                </aside>

                <!-- Zone principale de chat -->
                <main class="flex-1 flex flex-col bg-white" aria-label="Zone de discussion">
                    @if($activeDiscuss)
                        <!-- Chat Header -->
                        <header class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg" aria-hidden="true">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-xl font-bold text-white">{{ $activeDiscuss->agent->subject->theme ?? 'Educ-AI Assistant' }}</h1>
                                        <p class="text-blue-100 text-sm">Assistant d'apprentissage intelligent</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-semibold rounded-full flex items-center gap-2 shadow-sm" aria-label="Statut: en ligne">
                                    <span class="w-2 h-2 bg-white rounded-full animate-pulse" aria-hidden="true"></span>
                                    En ligne
                                </span>
                            </div>
                        </header>

                        <!-- Messages Container -->
                        <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gradient-to-b from-slate-50 to-white custom-scrollbar" role="log" aria-live="polite" aria-label="Messages de la conversation">
                            @forelse($activeDiscuss->messages as $message)
                                @if($message->type_message === 'user')
                                    <!-- User Message -->
                                    <div class="flex justify-end message-animation">
                                        <div class="max-w-[75%]">
                                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl rounded-tr-sm shadow-md p-4">
                                                <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                            </div>
                                            <time class="text-xs text-slate-500 mt-1.5 block text-right">{{ $message->created_at->format('H:i') }}</time>
                                        </div>
                                    </div>
                                @else
                                    <!-- Assistant Message -->
                                    <div class="flex items-start gap-3 message-animation">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm" aria-hidden="true">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 max-w-[75%]">
                                            <div class="bg-white rounded-2xl rounded-tl-sm shadow-md p-4 border border-slate-200">
                                                <div class="text-slate-800 markdown-content" data-markdown>{{ $message->message }}</div>
                                            </div>
                                            <time class="text-xs text-slate-500 mt-1.5 block">{{ $message->created_at->format('H:i') }}</time>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <!-- Welcome Message -->
                                <div class="flex items-start gap-3 message-animation">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm" aria-hidden="true">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl rounded-tl-sm shadow-md p-4 border border-slate-200">
                                            <p class="text-slate-800">
                                                Bonjour <span class="font-semibold text-blue-600">{{ Auth::user()->firstname }}</span> !
                                            </p>
                                            <p class="text-slate-700 mt-2">
                                                Je suis votre assistant Educ-AI en <strong class="text-blue-600">{{ $activeDiscuss->agent->subject->theme }}</strong>. Je suis là pour vous aider dans vos études. N'hésitez pas à me poser vos questions !
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Typing Indicator -->
                        <div id="typingIndicator" class="px-6 pb-2 hidden" role="status" aria-live="polite" aria-label="L'assistant est en train d'écrire">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm" aria-hidden="true">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="bg-white rounded-2xl rounded-tl-sm shadow-md p-4 border border-slate-200">
                                    <div class="flex gap-1.5">
                                        <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0ms" aria-hidden="true"></div>
                                        <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 150ms" aria-hidden="true"></div>
                                        <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 300ms" aria-hidden="true"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Input -->
                        <div class="bg-white border-t border-slate-200 px-6 py-4 shadow-lg">
                            <form id="chatForm" class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label for="messageInput" class="sr-only">Tapez votre message</label>
                                    <textarea
                                        id="messageInput"
                                        rows="1"
                                        placeholder="Tapez votre message ici..."
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-shadow"
                                        style="max-height: 120px; overflow-y: auto;"
                                        aria-label="Zone de saisie du message"
                                        aria-describedby="charCount inputHelp"
                                    ></textarea>
                                    <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                                        <span id="inputHelp">Entrée pour envoyer, Shift+Entrée pour nouvelle ligne</span>
                                        <span id="charCount" aria-live="polite">0/1000</span>
                                    </div>
                                </div>
                                <button
                                    type="submit"
                                    id="sendButton"
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    aria-label="Envoyer le message"
                                >
                                    <span>Envoyer</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- No Active Conversation - Welcome Screen -->
                        <div class="flex-1 flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-8">
                            <div class="text-center max-w-md">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-bold text-slate-800 mb-3">Bienvenue sur Educ-AI !</h2>
                                <p class="text-slate-600 mb-8 leading-relaxed">
                                    Votre assistant d'apprentissage personnel. Sélectionnez une conversation existante ou créez-en une nouvelle pour commencer à apprendre.
                                </p>
                                <button onclick="openNewChatModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Démarrer une conversation</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </main>

            </div>
        </div>
    </div>

    <!-- New Chat Modal -->
    <div id="newChatModal" class="hidden fixed inset-0 bg-slate-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50" style="display: none;" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg" aria-hidden="true">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="modalTitle" class="text-xl font-bold text-white">Choisissez votre matière</h2>
                                <p class="text-blue-100 text-sm mt-0.5">Sélectionnez une matière pour commencer à apprendre</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeNewChatModal()" class="text-white hover:bg-white hover:bg-opacity-20 transition-colors p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600" aria-label="Fermer la fenêtre">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('chat.store') }}" method="POST">
                    @csrf
                    <div class="p-6 max-h-[60vh] overflow-y-auto custom-scrollbar bg-slate-50">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="subjectsGrid" role="radiogroup" aria-label="Liste des matières disponibles">
                            @foreach($agents as $agent)
                                <label class="subject-card group relative cursor-pointer block focus-within:ring-2 focus-within:ring-blue-500 rounded-xl">
                                    <input
                                        type="radio"
                                        name="agent_id"
                                        value="{{ $agent->id }}"
                                        class="sr-only"
                                        required
                                        aria-label="{{ $agent->subject->theme ?? 'Général' }}"
                                    >
                                    <div class="card-content bg-white border-2 border-slate-200 rounded-xl p-5 transition-all duration-300 h-full flex flex-col items-center justify-center text-center gap-3 hover:shadow-lg hover:scale-105">
                                        <div class="card-icon w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-sm" aria-hidden="true">
                                            <svg class="icon-svg w-8 h-8 text-blue-600 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h3 class="card-title font-bold text-slate-900 text-sm leading-tight transition-all duration-300">
                                            {{ $agent->subject->theme ?? 'Général' }}
                                        </h3>
                                        <div class="card-badge absolute -top-2 -right-2 w-8 h-8 rounded-full bg-emerald-500 border-3 border-white flex items-center justify-center shadow-lg transition-all duration-300 opacity-0 scale-0" aria-hidden="true">
                                            <svg class="w-4 h-4 text-white font-bold" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-slate-50 px-6 py-4 flex justify-between items-center border-t border-slate-200 rounded-b-2xl">
                        <p class="text-sm text-slate-600" aria-live="polite">Sélectionnez une matière ci-dessus</p>
                        <div class="flex gap-3">
                            <button
                                type="button"
                                onclick="closeNewChatModal()"
                                class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-slate-400 font-medium transition-all text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                                Annuler
                            </button>
                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 font-semibold shadow-lg hover:shadow-xl transition-all text-sm flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span>Démarrer</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openNewChatModal() {
            const modal = document.getElementById('newChatModal');
            modal.classList.remove('hidden');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            initSubjectCards();

            // Focus sur le premier radio button pour l'accessibilité
            const firstRadio = modal.querySelector('input[type="radio"]');
            if (firstRadio) firstRadio.focus();
        }

        function closeNewChatModal() {
            const modal = document.getElementById('newChatModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fermer le modal avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('newChatModal');
                if (!modal.classList.contains('hidden')) {
                    closeNewChatModal();
                }
            }
        });

        // Initialiser les effets des cartes de matières
        function initSubjectCards() {
            const cards = document.querySelectorAll('.subject-card');

            cards.forEach(card => {
                const input = card.querySelector('input[type="radio"]');
                const cardContent = card.querySelector('.card-content');
                const cardIcon = card.querySelector('.card-icon');
                const iconSvg = card.querySelector('.icon-svg');
                const cardTitle = card.querySelector('.card-title');
                const cardBadge = card.querySelector('.card-badge');

                // Effet hover
                card.addEventListener('mouseenter', () => {
                    if (!input.checked) {
                        cardContent.style.borderColor = '#3b82f6';
                        cardContent.style.transform = 'translateY(-2px)';
                        cardIcon.style.background = 'linear-gradient(to bottom right, #3b82f6, #4f46e5)';
                        iconSvg.style.color = '#ffffff';
                        cardTitle.style.color = '#1e40af';
                    }
                });

                card.addEventListener('mouseleave', () => {
                    if (!input.checked) {
                        cardContent.style.borderColor = '#e2e8f0';
                        cardContent.style.transform = 'translateY(0)';
                        cardIcon.style.background = 'linear-gradient(to bottom right, #dbeafe, #e0e7ff)';
                        iconSvg.style.color = '#2563eb';
                        cardTitle.style.color = '#0f172a';
                    }
                });

                // Effet de sélection
                input.addEventListener('change', () => {
                    // Réinitialiser toutes les cartes
                    cards.forEach(c => {
                        const cInput = c.querySelector('input[type="radio"]');
                        const cCardContent = c.querySelector('.card-content');
                        const cCardIcon = c.querySelector('.card-icon');
                        const cIconSvg = c.querySelector('.icon-svg');
                        const cCardTitle = c.querySelector('.card-title');
                        const cCardBadge = c.querySelector('.card-badge');

                        if (!cInput.checked) {
                            cCardContent.style.background = 'white';
                            cCardContent.style.borderColor = '#e2e8f0';
                            cCardContent.style.boxShadow = '';
                            cCardContent.style.transform = 'scale(1)';

                            cCardIcon.style.background = 'linear-gradient(to bottom right, #dbeafe, #e0e7ff)';
                            cIconSvg.style.color = '#2563eb';

                            cCardTitle.style.color = '#0f172a';
                            cCardTitle.style.fontWeight = 'bold';

                            cCardBadge.style.opacity = '0';
                            cCardBadge.style.transform = 'scale(0)';
                        }
                    });

                    // Appliquer le style à la carte sélectionnée
                    if (input.checked) {
                        cardContent.style.background = 'linear-gradient(to bottom right, #2563eb, #4f46e5)';
                        cardContent.style.borderColor = '#2563eb';
                        cardContent.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                        cardContent.style.transform = 'scale(1.05)';

                        cardIcon.style.background = 'linear-gradient(to bottom right, #ffffff, #f1f5f9)';
                        iconSvg.style.color = '#2563eb';

                        cardTitle.style.color = '#ffffff';
                        cardTitle.style.fontWeight = '800';

                        cardBadge.style.opacity = '1';
                        cardBadge.style.transform = 'scale(1)';
                    }
                });

                // Support clavier
                card.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        input.checked = true;
                        input.dispatchEvent(new Event('change'));
                    }
                });
            });
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
                messageDiv.classList.add('message-animation');
                const currentTime = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

                if (sender === 'user') {
                    messageDiv.className = 'flex justify-end message-animation';
                    messageDiv.innerHTML = `
                        <div class="max-w-[75%]">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl rounded-tr-sm shadow-md p-4">
                                <p class="text-sm leading-relaxed">${escapeHtml(text)}</p>
                            </div>
                            <time class="text-xs text-slate-500 mt-1.5 block text-right">${currentTime}</time>
                        </div>
                    `;
                } else {
                    messageDiv.className = 'flex items-start gap-3 message-animation';
                    const htmlContent = marked.parse(text);
                    messageDiv.innerHTML = `
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 max-w-[75%]">
                            <div class="bg-white rounded-2xl rounded-tl-sm shadow-md p-4 border border-slate-200">
                                <div class="text-slate-800 markdown-content">${htmlContent}</div>
                            </div>
                            <time class="text-xs text-slate-500 mt-1.5 block">${currentTime}</time>
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
        @endif
    </script>
</x-public-layout>
