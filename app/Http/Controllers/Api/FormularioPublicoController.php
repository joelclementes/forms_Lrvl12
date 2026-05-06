<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use App\Models\FormularioRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormularioPublicoController extends Controller
{
    public function show(string $slug)
    {
        $formulario = Formulario::with(['campos' => function ($query) {
                $query->orderBy('orden');
            }])
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        return response()->json([
            'id' => $formulario->id,
            'nombre' => $formulario->nombre,
            'slug' => $formulario->slug,
            'descripcion' => $formulario->descripcion,
            'configuracion' => $formulario->configuracion,
            'campos' => $formulario->campos->map(function ($campo) {
                return [
                    'id' => $campo->id,
                    'etiqueta' => $campo->etiqueta,
                    'nombre_campo' => $campo->nombre_campo,
                    'tipo' => $campo->tipo,
                    'requerido' => $campo->requerido,
                    'es_unico' => $campo->es_unico,
                    'opciones' => $campo->opciones,
                    'orden' => $campo->orden,
                ];
            }),
        ]);
    }

    public function store(Request $request, string $slug)
{
    $formulario = Formulario::with('campos')
        ->where('slug', $slug)
        ->where('activo', true)
        ->firstOrFail();

    $reglas = [];

    foreach ($formulario->campos as $campo) {
        $reglaCampo = [];

        $reglaCampo[] = $campo->requerido ? 'required' : 'nullable';

        match ($campo->tipo) {
            'email' => $reglaCampo[] = 'email',
            'number' => $reglaCampo[] = 'numeric',
            'date' => $reglaCampo[] = 'date',
            'file' => array_push($reglaCampo, 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx'),
            default => null,
        };

        $reglas[$campo->nombre_campo] = $reglaCampo;
    }

    $validator = Validator::make($request->all(), $reglas);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Hay errores en el formulario.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $datos = [];

    foreach ($formulario->campos as $campo) {
        $nombreCampo = $campo->nombre_campo;

        if ($campo->tipo === 'file') {
            if ($request->hasFile($nombreCampo)) {
                $archivo = $request->file($nombreCampo);

                $ruta = $archivo->store(
                    "formularios/{$formulario->id}/respuestas",
                    'public'
                );

                $datos[$nombreCampo] = [
                    'ruta' => $ruta,
                    'nombre_original' => $archivo->getClientOriginalName(),
                    'mime' => $archivo->getClientMimeType(),
                    'size' => $archivo->getSize(),
                ];
            }

            continue;
        }

        $datos[$nombreCampo] = $request->input($nombreCampo);
    }

    foreach ($formulario->campos as $campo) {
        if (! $campo->es_unico) {
            continue;
        }

        $nombreCampo = $campo->nombre_campo;
        $valor = $datos[$nombreCampo] ?? null;

        if ($valor === null || $valor === '') {
            continue;
        }

        $yaExiste = FormularioRespuesta::where('formulario_id', $formulario->id)
            ->where("datos->{$nombreCampo}", $valor)
            ->exists();

        if ($yaExiste) {
            return response()->json([
                'message' => 'Ya existe un registro con información duplicada.',
                'errors' => [
                    $nombreCampo => [
                        "Ya existe un registro con este valor en: {$campo->etiqueta}.",
                    ],
                ],
            ], 422);
        }
    }

    FormularioRespuesta::create([
        'formulario_id' => $formulario->id,
        'datos' => $datos,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    return response()->json([
        'message' => 'Respuesta guardada correctamente.',
    ], 201);
}
}
