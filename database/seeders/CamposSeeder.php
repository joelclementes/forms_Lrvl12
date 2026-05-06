<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormularioCampo;

class CamposSeeder extends Seeder
{
    public function run(): void
    {
        $campos = [
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Nombre completo',
                    'nombre_campo' => 'nombre_completo',
                    'tipo' => 'text',
                    'requerido' => 1,
                    'es_unico' => 0,
                    'opciones' => null,
                    'orden' => 1,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Sexo',
                    'nombre_campo' => 'sexo',
                    'tipo' => 'radio',
                    'requerido' => 1,
                    'es_unico' => 0,
                    'opciones' => [
                        [
                            'label' => 'Masculino',
                            'value' => 'masculino'
                        ],
                        [
                            'label' => 'Femenino',
                            'value' => 'femenino'
                        ]
                    ],
                    'orden' => 2,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Dirección',
                    'nombre_campo' => 'direccion',
                    'tipo' => 'text',
                    'requerido' => 1,
                    'es_unico' => 0,
                    'opciones' => null,
                    'orden' => 3,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Correo e.',
                    'nombre_campo' => 'correo',
                    'tipo' => 'text',
                    'requerido' => 1,
                    'es_unico' => 1,
                    'opciones' => null,
                    'orden' => 4,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Grado máximo de estudios',
                    'nombre_campo' => 'grado_escolar',
                    'tipo' => 'select',
                    'requerido' => 1,
                    'es_unico' => 0,
                    'opciones' => [
                        [
                            'label' => 'Primaria',
                            'value' => 'primaria'
                        ],
                        [
                            'label' => 'Secundaria',
                            'value' => 'secundaria'
                        ],
                        [
                            'label' => 'Bachillerato',
                            'value' => 'bachillerato'
                        ],
                        [
                            'label' => 'Licenciatura',
                            'value' => 'licenciatura'
                        ],
                        [
                            'label' => 'Maestría',
                            'value' => 'maestría'
                        ],
                        [
                            'label' => 'Doctorado',
                            'value' => 'doctorado'
                        ],
                    ],
                    'orden' => 5,
                ],
            ],
        ];

        foreach ($campos as $campo) {
            $user = FormularioCampo::create($campo['campo_data']);
        }
    }
}
