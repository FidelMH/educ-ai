<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la matière') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('ID') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $subject->id }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Thème') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $subject->theme }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Date de création') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $subject->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Dernière mise à jour') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $subject->updated_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('subjects.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Retour à la liste') }}
                        </a>
                        <a href="{{ route('subjects.edit', $subject) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Modifier') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>