<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioCampo extends Model
{
    protected $table = 'formulario_campos';

    protected $fillable = [
        'formulario_id',
        'etiqueta',
        'nombre_campo',
        'tipo',
        'requerido',
        'es_unico',
        'opciones',
        'orden',
    ];

    protected $casts = [
        'opciones' => 'array',
        'requerido' => 'boolean',
        'es_unico' => 'boolean',
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}
