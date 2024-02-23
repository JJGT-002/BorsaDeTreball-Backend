<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Compañía y Usuario') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf

                    {{-- Datos del usuario --}}
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
                        <input type="email" name="email" id="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="email">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                        <input type="password" name="password" id="password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="current-password">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Dirección:</label>
                        <input type="text" name="address" id="address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="address">
                        @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">¿Acepta las condiciones de uso?</label>
                        <div class="mt-1">
                            <div class="flex items-center">
                                <input id="accept_yes" name="accept" type="radio" value="1" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                <label for="accept_yes" class="ml-3 block text-sm font-medium text-gray-700">Sí</label>
                            </div>
                            <div class="flex items-center mt-2">
                                <input id="accept_no" name="accept" type="radio" value="0" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                <label for="accept_no" class="ml-3 block text-sm font-medium text-gray-700">No</label>
                            </div>
                        </div>
                        @error('accept')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="observations" class="block text-sm font-medium text-gray-700">Observaciones:</label>
                        <textarea name="observations" id="observations" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>

                    {{-- Datos de la compañía --}}
                    <div class="mb-6">
                        <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la Compañía:</label>
                        <input type="text" name="name" id="name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="organization">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="cif" class="block text-sm font-medium text-gray-700">CIF:</label>
                        <input type="text" name="cif" id="cif" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="tax-id">
                        @error('cif')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="contact_name" class="block text-sm font-medium text-gray-700">Nombre de Contacto:</label>
                        <input type="text" name="contactName" id="contactName" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('contactName')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="company_web" class="block text-sm font-medium text-gray-700">Web de la Compañía:</label>
                        <input type="text" name="companyWeb" id="companyWeb" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" autocomplete="url">
                        @error('companyWeb')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Crear Compañía y Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
