<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de l\'Agent') }} #{{ $agent->id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('agents.edit', $agent) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
                <a href="{{ route('agents.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <!-- ID -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">ID</h3>
                            <p class="text-gray-900">{{ $agent->id }}</p>
                        </div>

                        <!-- Prompt -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Prompt</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $agent->prompt }}</p>
                            </div>
                        </div>

                        <!-- Matière -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Matière</h3>
                            <p class="text-gray-900">
                                @if($agent->subject)
                                    {{ $agent->subject->name }}
                                @else
                                    <span class="text-gray-500 italic">Non défini</span>
                                @endif
                            </p>
                        </div>

                        <!-- Niveau -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Niveau</h3>
                            <p class="text-gray-900">
                                @if($agent->level)
                                    {{ $agent->level->name }}
                                @else
                                    <span class="text-gray-500 italic">Non défini</span>
                                @endif
                            </p>
                        </div>

                        <!-- Discussion -->
                        <div class="border-b pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Discussion</h3>
                            <p class="text-gray-900">
                                @if($agent->discuss)
                                    {{ $agent->discuss->title }}
                                @else
                                    <span class="text-gray-500 italic">Non défini</span>
                                @endif
                            </p>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Date de création</h3>
                                <p class="text-gray-900">{{ $agent->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Dernière modification</h3>
                                <p class="text-gray-900">{{ $agent->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4">
                            <form action="{{ route('agents.destroy', $agent) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Supprimer l'agent
                                </button>
                            </form>

                            <a href="{{ route('agents.edit', $agent) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
