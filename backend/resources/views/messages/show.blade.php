<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Message #' . $message->id) }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('dashboard.messages.edit', $message) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
                <a href="{{ route('dashboard.messages.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">ID du Message</h3>
                            <p class="text-lg font-semibold text-gray-900">#{{ $message->id }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Type de message</h3>
                            <p class="text-lg">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $message->type_message }}
                                </span>
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Message</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Utilisateur</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $message->user->name ?? 'N/A' }}
                            </p>
                            @if($message->user)
                                <p class="text-sm text-gray-500">{{ $message->user->email }}</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Discussion</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('dashboard.discuss.show', $message->discuss_id) }}" class="text-blue-600 hover:text-blue-800">
                                    Discussion #{{ $message->discuss_id }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Agent</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('dashboard.agents.show', $message->agent_id) }}" class="text-blue-600 hover:text-blue-800">
                                    Agent #{{ $message->agent_id }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Créé le</h3>
                            <p class="text-lg text-gray-900">{{ $message->created_at->format('d/m/Y à H:i') }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Modifié le</h3>
                            <p class="text-lg text-gray-900">{{ $message->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <form action="{{ route('dashboard.messages.destroy', $message) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Supprimer ce message
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
