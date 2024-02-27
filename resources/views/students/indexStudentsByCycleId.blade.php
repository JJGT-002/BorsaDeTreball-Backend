<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Alumnos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->surnames }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('students.show', $student) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Ver</a>
                                        <a href="{{ route('students.edit', $student->id) }}" class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">Editar</a>
                                        <form action="{{ route('students.destroy', ['student' => $student, 'cycleId' => $cycleId]) }}" method="POST" class="inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-1">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
