<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar formulario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('formularios.update', $formulario) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre', $formulario->nombre) }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Slug
                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $formulario->slug) }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            rows="4"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                        >{{ old('descripcion', $formulario->descripcion) }}</textarea>
                    </div>

                    <div class="mb-4 flex items-center">
                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            @checked($formulario->activo)
                            class="rounded border-gray-300"
                        >

                        <label class="ml-2 text-sm text-gray-700">
                            Activo
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                        >
                            Guardar cambios
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
