<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouveau message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('dashboard.messages.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="type_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Type de message <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="type_message"
                                id="type_message"
                                value="{{ old('type_message') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                            @error('type_message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="message"
                                id="message"
                                rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Utilisateur <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="user_id"
                                id="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="">-- Sélectionner un utilisateur --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="discuss_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Discussion <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="discuss_id"
                                id="discuss_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="">-- Sélectionner une discussion --</option>
                                @foreach($discusses as $discuss)
                                    <option value="{{ $discuss->id }}" {{ old('discuss_id') == $discuss->id ? 'selected' : '' }}>
                                        Discussion #{{ $discuss->id }} - Agent #{{ $discuss->agent_id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('discuss_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Agent <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="agent_id"
                                id="agent_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                                <option value="">-- Sélectionner un agent --</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                        Agent #{{ $agent->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('dashboard.messages.index') }}" class="text-gray-600 hover:text-gray-900">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer le message
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
