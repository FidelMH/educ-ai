<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier le Niveau') }}
            </h2>
            <a href="{{ route('levels.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('levels.update', $level) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nom du niveau -->
                        <div>
                            <x-input-label for="level" :value="__('Nom du niveau')" />
                            <x-text-input
                                id="level"
                                name="level"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('level', $level->level)"
                                required
                                autofocus
                                placeholder="Ex: Débutant, Intermédiaire, Avancé..."
                            />
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 255 caractères.</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                                placeholder="Décrivez ce niveau en détail..."
                            >{{ old('description', $level->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 500 caractères.</p>
                        </div>

                        <!-- Information sur les agents associés -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Ce niveau est actuellement utilisé par <strong>{{ $level->agents()->count() }}</strong> agent(s).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('levels.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
