<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estudiantes Inscritos en las Ofertas de Trabajo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Oferta de Trabajo</h3>
                <div class="table-responsive">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->surnames }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->urlCV)
                                        <a href="{{ $student->urlCV }}" class="text-blue-500 hover:text-blue-700">Ver CV</a>
                                    @else
                                        Sin CV
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->jobOffer->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
