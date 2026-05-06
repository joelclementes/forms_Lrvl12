<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $formularios = Formulario::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('slug', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('form.index', compact('formularios', 'buscar'));
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
}
