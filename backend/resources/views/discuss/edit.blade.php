<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier la discussion #') . $discuss->id }}
            </h2>
            <a href="{{ route('dashboard.discuss.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Gestion des erreurs de validation globales -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oups !</strong>
                    <span class="block sm:inline">Il y a des problèmes avec vos données.</span>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('dashboard.discuss.update', $discuss) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Champ : Sélection de l'agent -->
                        <div>
                            <label for="agent_id" class="block text-sm font-medium text-gray-700">
                                Choisir l'Agent
                            </label>
                            <div class="mt-1">
                                <select id="agent_id" name="agent_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('agent_id', $discuss->agent_id) == $agent->id ? 'selected' : '' }}>
                                            Agent #{{ $agent->id }} - {{ $agent->subject->theme ?? 'Sans matière' }} ({{ Str::limit($agent->prompt, 40) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agent_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Changer l'agent modifiera le comportement pour les futurs messages de cette discussion.
                            </p>
                        </div>

                        <!-- Actions du formulaire -->
                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('dashboard.discuss.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </a>
                            
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Mettre à jour la discussion
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>