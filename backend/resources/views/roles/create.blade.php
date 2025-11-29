<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Créer un Rôle') }}
            </h2>
            <a href="{{ route('dashboard.roles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dashboard.roles.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nom du rôle -->
                        <div>
                            <x-input-label for="role" :value="__('Nom du rôle')" />
                            <x-text-input
                                id="role"
                                name="role"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('role')"
                                required
                                autofocus
                                placeholder="Ex: Admin, Professeur, Étudiant..."
                            />
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maximum 255 caractères. Le nom doit être unique.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard.roles.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Créer le rôle') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
