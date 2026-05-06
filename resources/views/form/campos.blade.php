<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Preguntas del formulario
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Nueva pregunta
                        </h3>

                        <form method="POST" action="{{ route('formularios.campos.store', $formulario) }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Pregunta / etiqueta
                                </label>

                                <input type="text" name="etiqueta" value="{{ old('etiqueta') }}" required
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Nombre interno del campo
                                </label>

                                <input type="text" name="nombre_campo" value="{{ old('nombre_campo') }}"
                                    placeholder="Se genera automáticamente si lo dejas vacío"
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">

                                <p class="text-xs text-gray-500 mt-1">
                                    Ejemplo: nombre_completo, correo, telefono.
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo de pregunta
                                </label>

                                <select name="tipo" id="tipoNuevoCampo" required
                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="text">Texto corto</option>
                                    <option value="textarea">Texto largo</option>
                                    <option value="email">Correo electrónico</option>
                                    <option value="number">Número</option>
                                    <option value="date">Fecha</option>
                                    <option value="select">Lista desplegable</option>
                                    <option value="radio">Opciones</option>
                                    <option value="checkbox">Casillas múltiples</option>
                                    <option value="file">Archivo</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="requerido" value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm">

                                    <span class="ml-2 text-sm text-gray-700">
                                        Pregunta obligatoria
                                    </span>
                                </label>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="esUnicoNuevoCampo" name="es_unico" value="1"
                                        @checked(old('es_unico'))
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm">

                                    <span class="ml-2 text-sm text-gray-700">
                                        No permitir respuestas duplicadas
                                    </span>
                                </label>

                                <p class="text-xs text-gray-500 mt-1">
                                    Si está activado, no se podrá repetir este valor en otro registro del mismo
                                    formulario.
                                </p>
                            </div>

                            <div class="mb-4" id="opcionesNuevoCampo">
                                <label class="block text-sm font-medium text-gray-700">
                                    Opciones
                                </label>

                                <textarea name="opciones_texto" rows="5" class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                                    placeholder="Una opción por línea">{{ old('opciones_texto') }}</textarea>

                                <p class="text-xs text-gray-500 mt-1">
                                    Solo aplica para lista desplegable, opción única y casillas múltiples.
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                Agregar pregunta
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Preguntas existentes
                            </h3>

                            <p class="text-sm text-gray-500">
                                Arrastra para ordenar
                            </p>
                        </div>

                        <div id="listaCampos" class="space-y-3">
                            @forelse ($campos as $campo)
                                <div class="border rounded-lg p-4 bg-gray-50" data-id="{{ $campo->id }}">

                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="cursor-move text-gray-400">☰</span>

                                                <h4 class="font-semibold text-gray-800">
                                                    {{ $campo->orden }}. {{ $campo->etiqueta }}
                                                </h4>
                                            </div>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Campo: <span class="font-mono">{{ $campo->nombre_campo }}</span>
                                                · Tipo: {{ $campo->tipo }}
                                                · {{ $campo->requerido ? 'Obligatorio' : 'Opcional' }}

                                                @if ($campo->es_unico)
                                                    · Único
                                                @endif
                                                {{-- · {{ $campo->requerido ? 'Obligatorio' : 'Opcional' }} --}}
                                            </p>

                                            @if (is_array($campo->opciones) && count($campo->opciones))
                                                <div class="mt-2 flex flex-wrap gap-2">
                                                    @foreach ($campo->opciones as $opcion)
                                                        <span
                                                            class="rounded-full bg-white border px-2 py-1 text-xs text-gray-700">
                                                            {{ $opcion['label'] ?? $opcion }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="button" onclick="abrirModalEditarCampo({{ $campo->id }})"
                                                class="rounded-md bg-yellow-500 px-3 py-2 text-white hover:bg-yellow-600"
                                                title="Editar pregunta">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l10.414-10.414a1 1 0 000-1.414l-3.586-3.586a1 1 0 00-1.414 0L4.293 14.707A1 1 0 004 15.414V20z" />
                                                </svg>
                                            </button>

                                            <form method="POST"
                                                action="{{ route('formularios.campos.destroy', [$formulario, $campo]) }}"
                                                onsubmit="return confirm('¿Eliminar esta pregunta?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-md bg-red-600 px-3 py-2 text-white hover:bg-red-700"
                                                    title="Eliminar pregunta">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="modalEditarCampo{{ $campo->id }}"
                                    class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50">
                                    <div class="flex min-h-screen items-center justify-center px-4">
                                        <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">

                                            <div class="mb-4 flex items-center justify-between">
                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    Editar pregunta
                                                </h3>

                                                <button type="button"
                                                    onclick="cerrarModalEditarCampo({{ $campo->id }})"
                                                    class="text-gray-500 hover:text-gray-700">
                                                    ✕
                                                </button>
                                            </div>

                                            <form method="POST"
                                                action="{{ route('formularios.campos.update', [$formulario, $campo]) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Pregunta / etiqueta
                                                    </label>

                                                    <input type="text" name="etiqueta"
                                                        value="{{ old('etiqueta', $campo->etiqueta) }}" required
                                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Nombre interno del campo
                                                    </label>

                                                    <input type="text" name="nombre_campo"
                                                        value="{{ old('nombre_campo', $campo->nombre_campo) }}"
                                                        required
                                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Tipo de pregunta
                                                    </label>

                                                    <select name="tipo" required
                                                        data-tipo-campo="{{ $campo->id }}"
                                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                                        @foreach ([
        'text' => 'Texto corto',
        'textarea' => 'Texto largo',
        'email' => 'Correo electrónico',
        'number' => 'Número',
        'date' => 'Fecha',
        'select' => 'Lista desplegable',
        'radio' => 'Opciones',
        'checkbox' => 'Casillas múltiples',
        'file' => 'Archivo',
    ] as $valor => $texto)
                                                            <option value="{{ $valor }}"
                                                                @selected($campo->tipo === $valor)>
                                                                {{ $texto }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="requerido" value="1"
                                                            @checked($campo->requerido)
                                                            class="rounded border-gray-300 text-indigo-600 shadow-sm">

                                                        <span class="ml-2 text-sm text-gray-700">
                                                            Pregunta obligatoria
                                                        </span>
                                                    </label>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="flex items-center">
                                                        <input id="esUnicoNuevoCampo" type="checkbox" name="es_unico"
                                                            value="1"
                                                            class="rounded border-gray-300 text-indigo-600 shadow-sm">

                                                        <span class="ml-2 text-sm text-gray-700">
                                                            No permitir respuestas duplicadas
                                                        </span>
                                                    </label>

                                                    <p id="ayudaEsUnicoNuevoCampo"
                                                        data-ayuda-es-unico="{{ $campo->id }}"
                                                        class="text-xs text-gray-500 mt-1">
                                                        Si está activado, no se podrá repetir este valor en otro
                                                        registro del mismo formulario.
                                                    </p>
                                                </div>

                                                {{-- <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Opciones
                                                    </label>

                                                    <textarea name="opciones_texto" rows="5" class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Una opción por línea">
                                                    @if (is_array($campo->opciones))
                                                    {{ collect($campo->opciones)->pluck('label')->implode("\n") }}
                                                    @endif
                                                    </textarea>
                                                </div> --}}
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Opciones
                                                    </label>

                                                    <textarea name="opciones_texto" rows="5" class="mt-1 w-full rounded-md border-gray-300 shadow-sm"
                                                        placeholder="Una opción por línea">{{ is_array($campo->opciones) ? collect($campo->opciones)->pluck('label')->implode("\n") : '' }}</textarea>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        onclick="cerrarModalEditarCampo({{ $campo->id }})"
                                                        class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                        Cancelar
                                                    </button>

                                                    <button type="submit"
                                                        class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                                        Guardar cambios
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="rounded-md border border-dashed border-gray-300 p-6 text-center text-gray-500">
                                    Este formulario todavía no tiene preguntas.
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function abrirModalEditarCampo(id) {
            document.getElementById('modalEditarCampo' + id).classList.remove('hidden');
        }

        function cerrarModalEditarCampo(id) {
            document.getElementById('modalEditarCampo' + id).classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const lista = document.getElementById('listaCampos');

            const tiposNoUnicos = ['checkbox', 'file', 'textarea'];

            const tipoNuevoCampo = document.getElementById('tipoNuevoCampo');
            const esUnicoNuevoCampo = document.getElementById('esUnicoNuevoCampo');
            const ayudaEsUnicoNuevoCampo = document.getElementById('ayudaEsUnicoNuevoCampo');

            function actualizarEsUnicoNuevoCampo() {
                if (!tipoNuevoCampo || !esUnicoNuevoCampo || !ayudaEsUnicoNuevoCampo) {
                    return;
                }

                const noPermitido = tiposNoUnicos.includes(tipoNuevoCampo.value);

                esUnicoNuevoCampo.disabled = noPermitido;

                if (noPermitido) {
                    esUnicoNuevoCampo.checked = false;
                    ayudaEsUnicoNuevoCampo.textContent =
                        'Este tipo de pregunta no permite validación de valor único.';
                    ayudaEsUnicoNuevoCampo.classList.remove('text-gray-500');
                    ayudaEsUnicoNuevoCampo.classList.add('text-red-600');
                } else {
                    ayudaEsUnicoNuevoCampo.textContent =
                        'Si está activado, no se podrá repetir este valor en otro registro del mismo formulario.';
                    ayudaEsUnicoNuevoCampo.classList.remove('text-red-600');
                    ayudaEsUnicoNuevoCampo.classList.add('text-gray-500');
                }
            }

            if (tipoNuevoCampo) {
                tipoNuevoCampo.addEventListener('change', actualizarEsUnicoNuevoCampo);
                actualizarEsUnicoNuevoCampo();
            }

            document.querySelectorAll('[data-tipo-campo]').forEach((selectTipo) => {
                const campoId = selectTipo.dataset.tipoCampo;
                const checkbox = document.querySelector(`[data-es-unico-checkbox="${campoId}"]`);
                const ayuda = document.querySelector(`[data-ayuda-es-unico="${campoId}"]`);

                function actualizarEsUnicoModal() {
                    if (!checkbox || !ayuda) {
                        return;
                    }

                    const noPermitido = tiposNoUnicos.includes(selectTipo.value);

                    checkbox.disabled = noPermitido;

                    if (noPermitido) {
                        checkbox.checked = false;
                        ayuda.textContent = 'Este tipo de pregunta no permite validación de valor único.';
                        ayuda.classList.remove('text-gray-500');
                        ayuda.classList.add('text-red-600');
                    } else {
                        ayuda.textContent =
                            'Si está activado, no se podrá repetir este valor en otro registro del mismo formulario.';
                        ayuda.classList.remove('text-red-600');
                        ayuda.classList.add('text-gray-500');
                    }
                }

                selectTipo.addEventListener('change', actualizarEsUnicoModal);
                actualizarEsUnicoModal();
            });

            if (!lista) {
                return;
            }

            let elementoArrastrado = null;

            lista.querySelectorAll('[data-id]').forEach((item) => {
                item.setAttribute('draggable', true);

                item.addEventListener('dragstart', () => {
                    elementoArrastrado = item;
                    item.classList.add('opacity-50');
                });

                item.addEventListener('dragend', () => {
                    elementoArrastrado = null;
                    item.classList.remove('opacity-50');
                    guardarOrden();
                });

                item.addEventListener('dragover', (event) => {
                    event.preventDefault();

                    const actual = event.currentTarget;

                    if (!elementoArrastrado || actual === elementoArrastrado) {
                        return;
                    }

                    const rect = actual.getBoundingClientRect();
                    const mitad = rect.top + rect.height / 2;

                    if (event.clientY < mitad) {
                        lista.insertBefore(elementoArrastrado, actual);
                    } else {
                        lista.insertBefore(elementoArrastrado, actual.nextSibling);
                    }
                });
            });

            function guardarOrden() {
                const campos = Array.from(lista.querySelectorAll('[data-id]'))
                    .map(item => item.dataset.id);

                fetch("{{ route('formularios.campos.ordenar', $formulario) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        campos
                    }),
                });
            }
        });
    </script>
</x-app-layout>
