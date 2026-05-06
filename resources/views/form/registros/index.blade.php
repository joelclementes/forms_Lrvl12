<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registros por formulario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Descripción</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Registrados</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($formularios as $formulario)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $formulario->nombre }}
                                    </td>

                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $formulario->descripcion }}
                                    </td>

                                    <td class="px-4 py-2 text-sm text-center">
                                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            {{ $formulario->respuestas_count }}
                                        </span>
                                    </td>


                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('formularios.registros.show', $formulario) }}"
                                        class="inline-flex items-center rounded-md bg-indigo-600 p-2 text-white hover:bg-indigo-700"
                                        title="Ver registros">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-5 w-5">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z" />
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z" />
                                            </svg>

                                        </a>
                                    </td>
                                    {{-- <td class="px-4 py-2 text-right">
                                        <a href="{{ route('formularios.registros.show', $formulario) }}"
                                           class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-700">
                                            Ver registros
                                        </a>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        No hay formularios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
