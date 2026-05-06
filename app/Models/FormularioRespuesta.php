<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormularioRespuesta extends Model
{
    protected $table = 'formulario_respuestas';

    protected $fillable = [
        'formulario_id',
        'datos',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'datos' => 'array',
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}
