<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier l\'Agent') }} #{{ $agent->id }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('agents.show', $agent) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Voir les détails
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
                    <form method="POST" action="{{ route('agents.update', $agent) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Prompt -->
                        <div>
                            <x-input-label for="prompt" :value="__('Prompt')" />
                            <textarea
                                id="prompt"
                                name="prompt"
                                rows="5"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                                autofocus
                            >{{ old('prompt', $agent->prompt) }}</textarea>
                            <x-input-error :messages="$errors->get('prompt')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 2000 caractères</p>
                        </div>

                        <!-- Subject -->
                        <div>
                            <x-input-label for="subject_id" :value="__('Matière')" />
                            <select
                                id="subject_id"
                                name="subject_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Sélectionnez une matière</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('subject_id', $agent->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->theme }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                        </div>

                        <!-- Level -->
                        <div>
                            <x-input-label for="level_id" :value="__('Niveau')" />
                            <select
                                id="level_id"
                                name="level_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Sélectionnez un niveau</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level_id', $agent->level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->level }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('level_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <form action="{{ route('agents.destroy', $agent) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Supprimer
                                </button>
                            </form>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('agents.show', $agent) }}" class="text-gray-600 hover:text-gray-900">
                                    Annuler
                                </a>
                                <x-primary-button>
                                    {{ __('Mettre à jour') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
