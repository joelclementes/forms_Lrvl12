<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Configuración del formulario
                </h2>
                <div class="flex">
                    <strong>Título:</strong>
                    <p class="text-sm text-gray-500 mt-1">
                         {{ $formulario->nombre }}
                    </p>
                </div>
                <div class="flex">
                    <strong>Descripción:</strong>
                    <p class="text-sm text-gray-500 mt-1">
                         {{ $formulario->descripcion }}
                    </p>
                </div>
            </div>
            <a href="{{ route('formularios.index') }}"
                class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">
                Volver
            </a>
        </div>
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
                                <input type="url" name="APP_LOGO"
                                    value="{{ old('APP_LOGO', $configuracion['APP_LOGO'] ?? '') }}"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_LOGO')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Slogan</label>
                                <input type="text" name="APP_SLOGAN"
                                    value="{{ old('APP_SLOGAN', $configuracion['APP_SLOGAN'] ?? '') }}"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_SLOGAN')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL del enlace</label>
                                <input type="url" name="APP_URL_LINK"
                                    value="{{ old('APP_URL_LINK', $configuracion['APP_URL_LINK'] ?? '') }}"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @error('APP_URL_LINK')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Texto del enlace</label>
                                <input type="text" name="APP_TITLE_LINK"
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

                        <div class="flex flex-col gap-3">
                            @php
                                $header = $configuracion['HEADER_CONFIG'] ?? [];
                                $tipo = old('HEADER_CONFIG.type', $header['type'] ?? 'multicolor');
                            @endphp

                            {{-- Color del título --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Color del título
                                </label>

                                <input type="color" name="HEADER_CONFIG[text_title_color]"
                                    value="{{ old('HEADER_CONFIG.text_title_color', $header['text_title_color'] ?? '#ffffff') }}"
                                    class="mt-1 h-10  rounded-md border-gray-300">
                            </div>

                            {{-- Tipo de fondo --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo de fondo del encabezado
                                </label>
                                <select name="HEADER_CONFIG[type]"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="solid" @selected($tipo === 'solid')>
                                        Sólido
                                    </option>

                                    <option value="gradient" @selected($tipo === 'gradient')>
                                        Degradado
                                    </option>

                                    <option value="multicolor" @selected($tipo === 'multicolor')>
                                        Multicolor
                                    </option>
                                </select>
                                @error('HEADER_CONFIG.type')
                                    <p class="text-sm text-red-600 mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Color sólido --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Color sólido
                                </label>
                                <input type="color" name="HEADER_CONFIG[solid_color]"
                                    value="{{ old('HEADER_CONFIG.solid_color', $header['solid_color'] ?? '#ffffff') }}"
                                    class="mt-1 h-10 rounded-md border-gray-300">
                            </div>

                            {{-- Degradado --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Degradado
                                </label>
                                <div class="flex  gap-3">
                                    <div>
                                        <input type="color" name="HEADER_CONFIG[gradient_start]"
                                            value="{{ old('HEADER_CONFIG.gradient_start', $header['gradient_start'] ?? '#ece9e6') }}"
                                            class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                    </div>
                                    <div>
                                        <input type="color" name="HEADER_CONFIG[gradient_end]"
                                            value="{{ old('HEADER_CONFIG.gradient_end', $header['gradient_end'] ?? '#ffffff') }}"
                                            class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                    </div>
                                </div>
                            </div>

                            {{-- Multicolor --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Multicolor
                                </label>
                                <div class="flex gap-3">
                                    <div>
                                        <input type="color" name="HEADER_CONFIG[multicolor_1]"
                                            value="{{ old('HEADER_CONFIG.multicolor_1', $header['multicolor_1'] ?? '#fe4875') }}"
                                            class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                    </div>
                                    <div>
                                        <input type="color" name="HEADER_CONFIG[multicolor_2]"
                                            value="{{ old('HEADER_CONFIG.multicolor_2', $header['multicolor_2'] ?? '#8a75e5') }}"
                                            class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                    </div>
                                    <div>
                                        <input type="color" name="HEADER_CONFIG[multicolor_3]"
                                            value="{{ old('HEADER_CONFIG.multicolor_3', $header['multicolor_3'] ?? '#3d75ed') }}"
                                            class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="flex flex-col gap-3">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Color de texto del footer
                                    </label>
                                    <input type="color" name="HEADER_CONFIG[text_footer_color]"
                                        value="{{ old('HEADER_CONFIG.text_footer_color', $header['text_footer_color'] ?? '#ffbdd9') }}"
                                        class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Color de fondo del footer
                                    </label>
                                    <input type="color" name="HEADER_CONFIG[footer_color]"
                                        value="{{ old('HEADER_CONFIG.footer_color', $header['footer_color'] ?? '#6c143a') }}"
                                        class="mt-1 h-10 w-50 rounded-md border-gray-300">
                                </div>
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
