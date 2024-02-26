<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Lista de Responsables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <form action="{{ route('responsibles.index') }}" method="GET" class="text-center">
                    <div class="flex items-center justify-center">
                        <input type="text" name="search" placeholder="Buscar por responsable" class="mr-4 px-4 py-2 border border-gray-300 rounded-md">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="flex justify-end mb-4">
                <a href="{{ route('responsibles.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded">+ Nuevo responsable</a>
            </div>

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-center">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>

                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dirección
                        </th>

                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Observaciones
                        </th>

                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @forelse($responsibles as $responsible)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $responsible->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $responsible->address }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $responsible->observations }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('users.show', $responsible->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2">Ver</a>
                                    <a href="{{ route('responsibles.indexCyclesByResponsible', $responsible->id) }}" class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-1 px-2 rounded mr-2">Ver ciclos</a>
                                    <a href="{{ route('responsibles.indexCyclesWithoutResponsible',$responsible->id) }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded mr-2">+ Asignar ciclo</a>
                                    <a href="{{ route('responsibles.edit', $responsible) }}" class="inline-block bg-blue-600 hover:bg-blue-900 text-white font-bold py-1 px-2 rounded ml-1">Editar</a>
                                    <form action="{{ route('responsibles.destroy', $responsible) }}" method="POST" class="inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-1">Eliminar responsable</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-500">No hay responsables</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
