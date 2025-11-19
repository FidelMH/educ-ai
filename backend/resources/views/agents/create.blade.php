<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Agent') }}
            </h2>
            <a href="{{ route('agents.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('agents.store') }}" class="space-y-6">
                        @csrf

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
                            >{{ old('prompt') }}</textarea>
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
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                                    <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->level }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('level_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('agents.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Créer l\'agent') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
