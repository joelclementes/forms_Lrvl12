<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FormularioCampo;
use Illuminate\Validation\Rule;
use App\Models\FormularioRespuesta;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $formularios = Formulario::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('slug', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('form.index', compact('formularios', 'buscar', 'perPage'));
    }


    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:formularios,slug'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['nombre']);

        $validated['activo'] = $request->boolean('activo');
        $validated['configuracion'] = $this->configuracionDefault();
        Formulario::create($validated);

        return redirect()
            ->route('formularios.index')
            ->with('success', 'Formulario creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulario $formulario)
    {
        return view('form.edit', compact('formulario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulario $formulario)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:formularios,slug,' . $formulario->id,
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug']
            ? Str::slug($validated['slug'])
            : Str::slug($validated['nombre']);

        $validated['activo'] = $request->boolean('activo');

        $formulario->update($validated);

        return redirect()
            ->route('formularios.index')
            ->with('success', 'Formulario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulario $formulario)
    {
        //
    }

    public function configuracion(Formulario $formulario)
    {
        $configuracion = $formulario->configuracion ?? $this->configuracionDefault();

        return view('form.configuracion', compact('formulario', 'configuracion'));
    }

    public function actualizarConfiguracion(Request $request, Formulario $formulario)
    {
        $validated = $request->validate([
            'APP_LOGO' => ['nullable', 'url', 'max:500'],
            'APP_SLOGAN' => ['nullable', 'string', 'max:255'],
            'APP_URL_LINK' => ['nullable', 'url', 'max:500'],
            'APP_TITLE_LINK' => ['nullable', 'string', 'max:255'],

            'HEADER_CONFIG.text_title_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.text_footer_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.type' => ['required', 'in:solid,gradient,multicolor'],
            'HEADER_CONFIG.solid_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.gradient_start' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.gradient_end' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.multicolor_1' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.multicolor_2' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.multicolor_3' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'HEADER_CONFIG.footer_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $formulario->update([
            'configuracion' => $validated,
        ]);

        return redirect()
            ->route('formularios.configuracion', $formulario)
            ->with('success', 'Configuración actualizada correctamente.');
    }

    private function configuracionDefault(): array
    {
        return [
            'APP_LOGO' => 'https://legisver.gob.mx/img/LOGO_LXVII_SLOGAN.jpg',
            'APP_SLOGAN' => 'Congreso del Estado de Veracruz',
            'APP_URL_LINK' => 'https://legisver.gob.mx',
            'APP_TITLE_LINK' => 'Aviso de privacidad',

            'HEADER_CONFIG' => [
                'text_title_color' => '#ffffff',
                'text_footer_color' => '#ffbdd9',
                'type' => 'multicolor',
                'solid_color' => '#ffffff',
                'gradient_start' => '#ece9e6',
                'gradient_end' => '#ffffff',
                'multicolor_1' => '#fe4875',
                'multicolor_2' => '#8a75e5',
                'multicolor_3' => '#3d75ed',
                'footer_color' => '#6c143a',
            ],
        ];
    }

    public function campos(Formulario $formulario)
    {
        $campos = $formulario->campos()->orderBy('orden')->get();

        return view('form.campos', compact('formulario', 'campos'));
    }

    public function guardarCampo(Request $request, Formulario $formulario)
    {
        $validated = $request->validate([
            'etiqueta' => ['required', 'string', 'max:255'],
            'nombre_campo' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('formulario_campos', 'nombre_campo')
                    ->where('formulario_id', $formulario->id),
            ],
            'tipo' => [
                'required',
                Rule::in([
                    'text',
                    'email',
                    'number',
                    'textarea',
                    'select',
                    'radio',
                    'checkbox',
                    'date',
                    'file',
                ]),
            ],
            'requerido' => ['nullable', 'boolean'],
            'es_unico' => ['nullable', 'boolean'],
            'opciones_texto' => ['nullable', 'string'],
        ]);

        $tipo = $validated['tipo'];

        $opciones = $this->normalizarOpciones(
            $request->input('opciones_texto'),
            $tipo
        );

        if (
            $request->boolean('es_unico') &&
            in_array($tipo, ['checkbox', 'file', 'textarea'], true)
        ) {
            return back()
                ->withErrors([
                    'es_unico' => 'Este tipo de pregunta no puede marcarse como única.',
                ])
                ->withInput();
        }

        if (in_array($tipo, ['select', 'radio', 'checkbox'], true) && empty($opciones)) {
            return back()
                ->withErrors(['opciones_texto' => 'Este tipo de campo requiere al menos una opción.'])
                ->withInput();
        }

        $orden = ((int) $formulario->campos()->max('orden')) + 1;

        $nombreCampo = $validated['nombre_campo']
            ? Str::slug($validated['nombre_campo'], '_')
            : Str::slug($validated['etiqueta'], '_');

        FormularioCampo::create([
            'formulario_id' => $formulario->id,
            'etiqueta' => $validated['etiqueta'],
            'nombre_campo' => $nombreCampo,
            'tipo' => $tipo,
            'requerido' => $request->boolean('requerido'),
            'es_unico' => $request->boolean('es_unico'),
            'opciones' => $opciones,
            'orden' => $orden,
        ]);

        return redirect()
            ->route('formularios.campos', $formulario)
            ->with('success', 'Pregunta agregada correctamente.');
    }

    public function actualizarCampo(Request $request, Formulario $formulario, FormularioCampo $campo)
    {
        abort_unless($campo->formulario_id === $formulario->id, 404);

        $validated = $request->validate([
            'etiqueta' => ['required', 'string', 'max:255'],
            'nombre_campo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('formulario_campos', 'nombre_campo')
                    ->where('formulario_id', $formulario->id)
                    ->ignore($campo->id),
            ],
            'tipo' => [
                'required',
                Rule::in([
                    'text',
                    'email',
                    'number',
                    'textarea',
                    'select',
                    'radio',
                    'checkbox',
                    'date',
                    'file',
                ]),
            ],
            'requerido' => ['nullable', 'boolean'],
            'es_unico' => ['nullable', 'boolean'],
            'opciones_texto' => ['nullable', 'string'],
        ]);

        $tipo = $validated['tipo'];

        $opciones = $this->normalizarOpciones(
            $request->input('opciones_texto'),
            $tipo
        );

        if (
            $request->boolean('es_unico') &&
            in_array($tipo, ['checkbox', 'file', 'textarea'], true)
        ) {
            return back()
                ->withErrors([
                    'es_unico' => 'Este tipo de pregunta no puede marcarse como única.',
                ])
                ->withInput();
        }

        if (in_array($tipo, ['select', 'radio', 'checkbox'], true) && empty($opciones)) {
            return back()
                ->withErrors(['opciones_texto' => 'Este tipo de campo requiere al menos una opción.'])
                ->withInput();
        }

        $campo->update([
            'etiqueta' => $validated['etiqueta'],
            'nombre_campo' => Str::slug($validated['nombre_campo'], '_'),
            'tipo' => $tipo,
            'requerido' => $request->boolean('requerido'),
            'es_unico' => $request->boolean('es_unico'),
            'opciones' => $opciones,
        ]);

        return redirect()
            ->route('formularios.campos', $formulario)
            ->with('success', 'Pregunta actualizada correctamente.');
    }

    public function eliminarCampo(Formulario $formulario, FormularioCampo $campo)
    {
        abort_unless($campo->formulario_id === $formulario->id, 404);

        $campo->delete();

        $this->reordenarCampos($formulario);

        return redirect()
            ->route('formularios.campos', $formulario)
            ->with('success', 'Pregunta eliminada correctamente.');
    }

    public function ordenarCampos(Request $request, Formulario $formulario)
    {
        $validated = $request->validate([
            'campos' => ['required', 'array'],
            'campos.*' => ['integer', 'exists:formulario_campos,id'],
        ]);

        foreach ($validated['campos'] as $index => $campoId) {
            FormularioCampo::where('id', $campoId)
                ->where('formulario_id', $formulario->id)
                ->update(['orden' => $index + 1]);
        }

        return response()->json([
            'message' => 'Orden actualizado correctamente.',
        ]);
    }

    private function normalizarOpciones(?string $opcionesTexto, string $tipo): ?array
    {
        if (! in_array($tipo, ['select', 'radio', 'checkbox'], true)) {
            return null;
        }

        return collect(preg_split('/\r\n|\r|\n/', (string) $opcionesTexto))
            ->map(fn ($opcion) => trim($opcion))
            ->filter()
            ->map(fn ($opcion) => [
                'label' => $opcion,
                'value' => Str::slug($opcion, '_'),
            ])
            ->values()
            ->all();
    }

    private function reordenarCampos(Formulario $formulario): void
    {
        $formulario->campos()
            ->orderBy('orden')
            ->get()
            ->each(function ($campo, $index) {
                $campo->update([
                    'orden' => $index + 1,
                ]);
            });
    }

    public function indexRegistros()
    {
        $formularios = Formulario::withCount('respuestas')
            ->orderBy('id', 'desc')
            ->get();

        return view('form.registros.index', compact('formularios'));
    }

    public function registros(Request $request, Formulario $formulario)
    {
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $buscar = $request->input('buscar');

        $respuestas = $formulario->respuestas()
            ->when($buscar, function ($query, $buscar) {
                $query->where('datos', 'like', "%{$buscar}%")
                    ->orWhere('ip', 'like', "%{$buscar}%")
                    ->orWhere('user_agent', 'like', "%{$buscar}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $campos = $formulario->campos()->orderBy('orden')->get();

        return view('form.registros.show', compact(
            'formulario',
            'respuestas',
            'campos',
            'buscar',
            'perPage'
        ));
    }

    public function exportarRegistros(Formulario $formulario): StreamedResponse
    {
        $campos = $formulario->campos()->orderBy('orden')->get();

        $nombreArchivo = 'registros_' . $formulario->slug . '_' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($formulario, $campos) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $encabezados = ['ID', 'Fecha de registro'];

            foreach ($campos as $campo) {
                $encabezados[] = $campo->etiqueta;
            }

            $encabezados[] = 'IP';

            fputcsv($handle, $encabezados);

            $formulario->respuestas()
                ->orderBy('id')
                ->chunk(500, function ($respuestas) use ($handle, $campos) {
                    foreach ($respuestas as $respuesta) {
                        $datos = $respuesta->datos ?? [];

                        $fila = [
                            $respuesta->id,
                            optional($respuesta->created_at)->format('Y-m-d H:i:s'),
                        ];

                        foreach ($campos as $campo) {
                            $valor = $datos[$campo->nombre_campo] ?? '';

                            if (is_array($valor)) {
                                $valor = implode(', ', $valor);
                            }

                            $fila[] = $valor;
                        }

                        $fila[] = $respuesta->ip;

                        fputcsv($handle, $fila);
                    }
                });

            fclose($handle);
        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function resetearRegistros(Formulario $formulario)
    {
        $formulario->respuestas()->delete();

        return redirect()
            ->route('formularios.registros.show', $formulario)
            ->with('success', 'Los registros del formulario fueron eliminados correctamente.');
    }

}
