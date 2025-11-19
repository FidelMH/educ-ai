<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Niveau') }}
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
                    <form method="POST" action="{{ route('levels.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nom du niveau -->
                        <div>
                            <x-input-label for="level" :value="__('Nom du niveau')" />
                            <x-text-input
                                id="level"
                                name="level"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('level')"
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
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 500 caractères.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('levels.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Créer le niveau') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
