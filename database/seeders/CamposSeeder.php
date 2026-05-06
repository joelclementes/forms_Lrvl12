<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormularioCampo;

class CamposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                    'opciones' => null,
                    'orden' => 1,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Dirección',
                    'nombre_campo' => 'direccion',
                    'tipo' => 'text',
                    'requerido' => 1,
                    'opciones' => null,
                    'orden' => 2,
                ],
            ],
            [
                'campo_data' => [
                    'formulario_id' => 1,
                    'etiqueta' => 'Sexo',
                    'nombre_campo' => 'sexo',
                    'tipo' => 'radio',
                    'requerido' => 1,
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
                    'orden' => 3,
                ],
            ],
        ];

        foreach ($campos as $campo) {
            $user = FormularioCampo::create($campo['campo_data']);
        }
    }
}
