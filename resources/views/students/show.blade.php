<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border-b-2 pb-4">
                        <h3 class="text-lg font-semibold mb-2">Información del Estudiante</h3>
                        <p><span class="font-semibold">ID:</span> {{ $student->id }}</p>
                        <p><span class="font-semibold">Nombre:</span> {{ $student->name }}</p>
                        <p><span class="font-semibold">Apellidos:</span> {{ $student->surnames }}</p>
                        <p><span class="font-semibold">CV:</span>
                            @if($student->urlCV)
                                <a href="{{ $student->urlCV }}" class="text-blue-500 hover:text-blue-700">{{ $student->urlCV }}</a>
                            @else
                                Sin CV
                            @endif
                        </p>
                        <p><span class="font-semibold">Creado:</span> {{ $student->created_at->format('Y-m-d H:i:s') }}</p>
                        <p><span class="font-semibold">Actualizado:</span> {{ $student->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="border-b-2 pb-4">
                        <h3 class="text-lg font-semibold mb-2">Información del Usuario</h3>
                        <p><span class="font-semibold">Correo Electrónico:</span> {{ $student->user->email }}</p>
                        <p><span class="font-semibold">Dirección:</span> {{ $student->user->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
