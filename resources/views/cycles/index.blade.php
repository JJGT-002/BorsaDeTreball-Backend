<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Ciclos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <form action="{{ route('cycles.index') }}" method="GET" class="text-center">
                    <div class="flex items-center justify-center">
                        <input type="text" name="search" placeholder="Buscar ciclo" class="mr-4 px-4 py-2 border border-gray-300 rounded-md">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-center">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @foreach($cycles as $cycle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cycle->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cycle->ciclo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('cycles.show', $cycle) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Ver</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $cycles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
