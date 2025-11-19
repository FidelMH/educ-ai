<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails du Niveau') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('levels.edit', $level) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
                <a href="{{ route('levels.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informations du niveau -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Informations générales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">ID</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $level->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nom du niveau</label>
                                <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $level->level }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Description</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $level->description }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date de création</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $level->created_at ? $level->created_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dernière modification</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $level->updated_at ? $level->updated_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des agents associés -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">
                            Agents associés
                            <span class="ml-2 px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $level->agents->count() }}
                            </span>
                        </h3>

                        @if($level->agents->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Prompt
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date de création
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($level->agents as $agent)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $agent->id }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    {{ Str::limit($agent->prompt, 80) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $agent->created_at ? $agent->created_at->format('d/m/Y') : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('agents.show', $agent) }}" class="text-blue-600 hover:text-blue-900">
                                                        Voir
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-gray-500">Aucun agent n'utilise ce niveau pour le moment.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 mt-8 flex justify-between items-center">
                        <form action="{{ route('levels.destroy', $level) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce niveau ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Supprimer ce niveau
                            </button>
                        </form>

                        <div class="space-x-2">
                            <a href="{{ route('levels.edit', $level) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
