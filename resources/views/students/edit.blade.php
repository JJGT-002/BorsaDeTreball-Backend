<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('students.update', $student->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $student->name }}" required autofocus />
                    </div>

                    <div class="mt-4">
                        <label for="surnames" class="block font-medium text-sm text-gray-700">Apellidos</label>
                        <input id="surnames" class="block mt-1 w-full" type="text" name="surnames" value="{{ $student->surnames }}" required />
                    </div>

                    <div class="mt-4">
                        <label for="urlCV" class="block font-medium text-sm text-gray-700">URL del CV</label>
                        <input id="urlCV" class="block mt-1 w-full" type="text" name="urlCV" value="{{ $student->urlCV }}" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Actualizar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
