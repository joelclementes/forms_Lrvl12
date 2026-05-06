<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'configuracion',
        'activo',
    ];

    protected $casts = [
        'configuracion' => 'array',
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    public function campos()
    {
        return $this->hasMany(FormularioCampo::class)->orderBy('orden');
    }
}
