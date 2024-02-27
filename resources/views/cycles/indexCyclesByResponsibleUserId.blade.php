<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Ciclos sin un Responsable Asignado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('responsibles.indexCyclesByResponsible', $responsibleId) }}" method="GET" class="text-center mb-6">
                    <div class="flex items-center justify-center">
                        <input type="text" name="search" placeholder="Buscar ciclo" class="mr-4 px-4 py-2 border border-gray-300 rounded-md">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                    </div>
                </form>

                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-500 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cyclesByResponsibleUserId as $cycle)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cycle->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cycle->ciclo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('cycles.show', $cycle) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Ver</a>
                                        @if($showRemoveButton)
                                            <a href="{{ route('responsibles.delete', ['responsibleId' => $responsibleId, 'cycleId' => $cycle->id]) }}" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Quitar</a>
                                        @endif
                                        <a href="{{ route('students.indexStudentsByCycleId', $cycle->id) }}" class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">Ver alumnos</a>
                                        <a href="{{ route('cycles.indexJobOffersByCycle', $cycle->id) }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Ver Ofertas de Trabajo</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $cyclesByResponsibleUserId->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
