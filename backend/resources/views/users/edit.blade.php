<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier l\'Utilisateur') }}
            </h2>
            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Prénom -->
                        <div>
                            <x-input-label for="firstname" :value="__('Prénom')" />
                            <x-text-input
                                id="firstname"
                                name="firstname"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('firstname', $user->firstname)"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                        </div>

                        <!-- Nom -->
                        <div>
                            <x-input-label for="lastname" :value="__('Nom')" />
                            <x-text-input
                                id="lastname"
                                name="lastname"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('lastname', $user->lastname)"
                                required
                            />
                            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                class="mt-1 block w-full"
                                :value="old('email', $user->email)"
                                required
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <x-input-label for="password" :value="__('Nouveau mot de passe (optionnel)')" />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Laissez vide si vous ne souhaitez pas changer le mot de passe.</p>
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                            <x-text-input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Rôle -->
                        <div>
                            <x-input-label for="roles_id" :value="__('Rôle')" />
                            <select
                                id="roles_id"
                                name="roles_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Sélectionnez un rôle</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('roles_id', $user->roles_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->role }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('roles_id')" class="mt-2" />
                        </div>

                        <!-- Consentement -->
                        <div class="flex items-center">
                            <input
                                id="consentement"
                                name="consentement"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ old('consentement', $user->consentement) ? 'checked' : '' }}
                            />
                            <label for="consentement" class="ml-2 block text-sm text-gray-900">
                                {{ __('Consentement RGPD') }}
                            </label>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-900">
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
