<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formularios
        </h2>
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
                    action="{{ route('formularios.index') }}"
                    class="flex flex-col md:flex-row gap-2">

                    <input
                        type="text"
                        name="buscar"
                        value="{{ $buscar }}"
                        placeholder="Buscar formulario..."
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                    <select
                        name="per_page"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        onchange="this.form.submit()"
                    >
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

                <button
                    type="button"
                    onclick="document.getElementById('modalNuevoFormulario').classList.remove('hidden')"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    Nuevo formulario
                </button>
            </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Nombre de la URL</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Descripción</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Activo</th>
                                <th colspan="3" class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                                {{-- <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">Acciones</th> --}}
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($formularios as $formulario)
                                <tr>

                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $formulario->nombre }}
                                    </td>

                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $formulario->slug }}
                                    </td>

                                    <td class="px-4 py-2 text-sm text-gray-700">
                                        {{ $formulario->descripcion }}
                                    </td>

                                    <td class="px-4 py-2 text-sm">
                                        @if ($formulario->activo)
                                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-700">
                                                Activo
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-2 py-1 text-xs text-red-700">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 text-right">
                                        <a
                                            href="{{ route('formularios.edit', $formulario) }}"
                                            class="inline-flex items-center rounded-md bg-yellow-500 px-3 py-2 text-white hover:bg-yellow-600"
                                            title="Editar formulario"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l10.414-10.414a1 1 0 000-1.414l-3.586-3.586a1 1 0 00-1.414 0L4.293 14.707A1 1 0 004 15.414V20z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <a
                                            href="{{ route('formularios.configuracion', $formulario) }}"
                                            class="inline-flex items-center rounded-md bg-purple-600 px-3 py-2 text-white hover:bg-purple-700"
                                            title="Configurar formulario"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <a
                                            href="{{ route('formularios.campos', $formulario) }}"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-white hover:bg-blue-700"
                                            title="Editar preguntas"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8.228 9.228a3 3 0 114.243 4.243c-.879.879-1.471 1.293-1.471 2.529M12 18h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        No hay formularios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $formularios->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal nuevo formulario --}}
    <div
        id="modalNuevoFormulario"
        class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50"
    >
        <div class="flex min-h-screen items-center justify-center px-4">
            <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-lg">

                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Nuevo formulario
                    </h3>

                    <button
                        type="button"
                        onclick="document.getElementById('modalNuevoFormulario').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        ✕
                    </button>
                </div>

                <form method="POST" action="{{ route('formularios.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre de la URL
                        </label>
                        <p class="text-sm text-gray-600">(Solo letras,números y guiones)</p>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="Ejemplo: registro-capacitacion"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Descripción
                        </label>
                        <textarea
                            name="descripcion"
                            required
                            rows="3"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            checked
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        >
                        <label class="ml-2 text-sm text-gray-700">
                            Activo
                        </label>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button
                            type="button"
                            onclick="document.getElementById('modalNuevoFormulario').classList.add('hidden')"
                            class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                        >
                            Guardar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
