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
        'opciones',
        'orden',
    ];

    protected $casts = [
        'opciones' => 'array',
        'requerido' => 'boolean',
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}
