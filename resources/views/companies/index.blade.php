<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Listado de Compañías') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <form action="{{ route('companies.index') }}" method="GET" class="text-center">
                    <div class="flex items-center justify-center">
                        <input type="text" name="search" placeholder="Buscar por compañía" class="mr-4 px-4 py-2 border border-gray-300 rounded-md">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="flex justify-end mb-4">
                <a href="{{ route('companies.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded">+ Nueva empresa</a>
            </div>

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-center">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center">
                    @forelse($companies as $company)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $company->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $company->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('companies.show', $company) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Ver</a>
                                    <a href="{{ route('jobOffers.indexByCompany', $company->id) }}" class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">Ver ofertas</a>
                                    <a href="{{ route('companies.edit', $company) }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded ml-1">Editar</a>
                                    <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-1">Eliminar compañía</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-500">No hay compañías</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
