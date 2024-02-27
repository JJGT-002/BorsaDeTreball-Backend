<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Ofertas de Trabajo') }}
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración del contrato</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método de registro</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jobOffers as $jobOffer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $jobOffer->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $jobOffer->company_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap overflow-hidden" style="max-width: 200px;">{{ strlen($jobOffer->description) > 200 ? substr($jobOffer->description, 0, 200) . '...' : $jobOffer->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $jobOffer->contractDuration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $jobOffer->contact }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $jobOffer->registrationMethod }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
