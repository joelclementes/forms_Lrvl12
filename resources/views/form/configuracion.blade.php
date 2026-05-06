<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración del formulario: {{ $formulario->nombre }}
        </h2>
        <p>
            Descripción: {{ $formulario->descripcion }}
        </p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('formularios.configuracion.update', $formulario) }}">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Información general
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Logo</label>
                                <input type="url"
                                       name="APP_LOGO"
                                       value="{{ old('APP_LOGO', $configuracion['APP_LOGO'] ?? '') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_LOGO')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Slogan</label>
                                <input type="text"
                                       name="APP_SLOGAN"
                                       value="{{ old('APP_SLOGAN', $configuracion['APP_SLOGAN'] ?? '') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_SLOGAN')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL del enlace</label>
                                <input type="url"
                                       name="APP_URL_LINK"
                                       value="{{ old('APP_URL_LINK', $configuracion['APP_URL_LINK'] ?? '') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_URL_LINK')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Texto del enlace</label>
                                <input type="text"
                                       name="APP_TITLE_LINK"
                                       value="{{ old('APP_TITLE_LINK', $configuracion['APP_TITLE_LINK'] ?? '') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_TITLE_LINK')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Colores del encabezado
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de fondo</label>
                                <select name="HEADER_CONFIG[type]"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                    @php
                                        $tipo = old('HEADER_CONFIG.type', $configuracion['HEADER_CONFIG']['type'] ?? 'multicolor');
                                    @endphp

                                    <option value="solid" @selected($tipo === 'solid')>Sólido</option>
                                    <option value="gradient" @selected($tipo === 'gradient')>Degradado</option>
                                    <option value="multicolor" @selected($tipo === 'multicolor')>Multicolor</option>
                                </select>
                                @error('HEADER_CONFIG.type')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @php
                                $header = $configuracion['HEADER_CONFIG'] ?? [];
                            @endphp

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Color del título</label>
                                <input type="color"
                                       name="HEADER_CONFIG[text_title_color]"
                                       value="{{ old('HEADER_CONFIG.text_title_color', $header['text_title_color'] ?? '#ffffff') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Color texto footer</label>
                                <input type="color"
                                       name="HEADER_CONFIG[text_footer_color]"
                                       value="{{ old('HEADER_CONFIG.text_footer_color', $header['text_footer_color'] ?? '#ffbdd9') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Color sólido</label>
                                <input type="color"
                                       name="HEADER_CONFIG[solid_color]"
                                       value="{{ old('HEADER_CONFIG.solid_color', $header['solid_color'] ?? '#ffffff') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Degradado inicio</label>
                                <input type="color"
                                       name="HEADER_CONFIG[gradient_start]"
                                       value="{{ old('HEADER_CONFIG.gradient_start', $header['gradient_start'] ?? '#ece9e6') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Degradado final</label>
                                <input type="color"
                                       name="HEADER_CONFIG[gradient_end]"
                                       value="{{ old('HEADER_CONFIG.gradient_end', $header['gradient_end'] ?? '#ffffff') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Multicolor 1</label>
                                <input type="color"
                                       name="HEADER_CONFIG[multicolor_1]"
                                       value="{{ old('HEADER_CONFIG.multicolor_1', $header['multicolor_1'] ?? '#fe4875') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Multicolor 2</label>
                                <input type="color"
                                       name="HEADER_CONFIG[multicolor_2]"
                                       value="{{ old('HEADER_CONFIG.multicolor_2', $header['multicolor_2'] ?? '#8a75e5') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Multicolor 3</label>
                                <input type="color"
                                       name="HEADER_CONFIG[multicolor_3]"
                                       value="{{ old('HEADER_CONFIG.multicolor_3', $header['multicolor_3'] ?? '#3d75ed') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Color del footer</label>
                                <input type="color"
                                       name="HEADER_CONFIG[footer_color]"
                                       value="{{ old('HEADER_CONFIG.footer_color', $header['footer_color'] ?? '#6c143a') }}"
                                       class="mt-1 h-10 w-full rounded-md border-gray-300">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('formularios.index') }}"
                           class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Volver
                        </a>

                        <button type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                            Guardar configuración
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
