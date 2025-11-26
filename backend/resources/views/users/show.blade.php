<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de l\'Utilisateur') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('dashboard.users.edit', $user) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
                <a href="{{ route('dashboard.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Retour à la liste
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Informations de l'utilisateur -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Informations générales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">ID</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Prénom</label>
                                <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->firstname }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nom</label>
                                <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->lastname }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Rôle</label>
                                <p class="mt-1 text-lg">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $user->role->role ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Consentement RGPD</label>
                                <p class="mt-1 text-lg">
                                    @if($user->consentement)
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            ✓ Oui
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                            ✗ Non
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date d'inscription</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dernière modification</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $user->updated_at ? $user->updated_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="border-t pt-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistiques</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-900">Messages</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ $user->messages->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 flex justify-between items-center">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Supprimer cet utilisateur
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Vous ne pouvez pas supprimer votre propre compte.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="space-x-2">
                            <a href="{{ route('dashboard.users.edit', $user) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
