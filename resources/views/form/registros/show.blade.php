<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Registros del formulario
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $formulario->nombre }}
                </p>
            </div>

            <a href="{{ route('formularios.registros.index') }}"
               class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <form method="GET"
                          action="{{ route('formularios.registros.show', $formulario) }}"
                          class="flex flex-col md:flex-row gap-2">

                        <input type="text"
                               name="buscar"
                               value="{{ $buscar }}"
                               placeholder="Buscar en registros..."
                               class="rounded-md border-gray-300 shadow-sm">

                        <select name="per_page"
                                class="rounded-md border-gray-300 shadow-sm"
                                onchange="this.form.submit()">
                            @foreach ([10, 20, 50, 100] as $cantidad)
                                <option value="{{ $cantidad }}" @selected($perPage == $cantidad)>
                                    {{ $cantidad }} registros
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                                class="rounded-md bg-gray-700 px-4 py-2 text-white hover:bg-gray-800">
                            Buscar
                        </button>
                    </form>

                    <div class="flex gap-2">
                        <a href="{{ route('formularios.registros.exportar', $formulario) }}"
                           class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                            Exportar CSV
                        </a>

                        <form method="POST"
                              action="{{ route('formularios.registros.resetear', $formulario) }}"
                              onsubmit="return confirm('¿Seguro que deseas borrar todos los registros de este formulario? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                Resetear formulario
                            </button>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">ID</th> --}}
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Fecha</th>

                                @foreach ($campos as $campo)
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                                        {{ $campo->etiqueta }}
                                    </th>
                                @endforeach

                                {{-- <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">IP</th> --}}
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($respuestas as $respuesta)
                                <tr>
                                    {{-- <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $respuesta->id }}
                                    </td> --}}

                                    <td class="px-4 py-2 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $respuesta->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    @foreach ($campos as $campo)
                                        @php
                                            $valor = $respuesta->datos[$campo->nombre_campo] ?? '';
                                            if (is_array($valor)) {
                                                $valor = implode(', ', $valor);
                                            }
                                        @endphp

                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            {{ $valor }}
                                        </td>
                                    @endforeach

                                    {{-- <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $respuesta->ip }}
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 3 + $campos->count() }}"
                                        class="px-4 py-6 text-center text-gray-500">
                                        No hay registros para este formulario.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $respuestas->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
