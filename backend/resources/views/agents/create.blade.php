<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Agent') }}
            </h2>
            <a href="{{ route('dashboard.agents.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dashboard.agents.store') }}" class="space-y-6">
                        @csrf

                        <!-- Subject -->
                        <div>
                            <x-input-label for="subject_id" :value="__('Matière (celles sans agent uniquement)')" />
                            <select
                                id="subject_id"
                                name="subject_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Sélectionnez une matière</option>
                                @foreach($subjectsWithoutAgent as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->theme }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                        </div>

                        <!-- Prompt -->
                        <div>
                            <x-input-label for="prompt" :value="__('Prompt de base')" />
                            <textarea
                                id="prompt"
                                name="prompt"
                                rows="5"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                                autofocus
                            >{{ old('prompt', "Tu es un excellent tuteur. Ton objectif est d'expliquer des concepts de manière claire et concise.") }}</textarea>
                            <x-input-error :messages="$errors->get('prompt')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Ce prompt de base sera complété dynamiquement avec le niveau de l'utilisateur lors d'une conversation.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard.agents.index') }}" class="text-gray-600 hover:text-gray-900">
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