<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Formulario;

class FormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formularios = [
            [
                'formulario_data' => [
                    'nombre' => 'Curso de Contabilidad para Tesoreros',
                    'slug' => 'curso-contabilidad-2026',
                    'descripcion' => 'Curso que se impartirá a los tesoreros de los 212 Ayuntamientos del Estado de Veracruz de Ignacio de la Llave.',
                    'configuracion' => [
                                            'APP_LOGO' => 'https://legisver.gob.mx/img/LOGO_LXVII_SLOGAN.jpg',
                                            'APP_SLOGAN' => 'Congreso del Estado de Veracruz',
                                            'APP_URL_LINK' => 'https://legisver.gob.mx',
                                            'APP_TITLE_LINK' => 'Aviso de privacidad',

                                            'HEADER_CONFIG' => [
                                                    'type' => 'multicolor',
                                                    'solid_color' => '#ffffff',
                                                    'footer_color' => '#6c143a',
                                                    'gradient_end' => '#ffffff',
                                                    'multicolor_1' => '#fe4875',
                                                    'multicolor_2' => '#8a75e5',
                                                    'multicolor_3' => '#3d75ed',
                                                    'gradient_start' => '#ece9e6',
                                                    'text_title_color' => '#ffffff',
                                                    'text_footer_color' => '#ffbdd9',
                                            ],
                                        ],
                    'activo' => true,
                ],
            ],
        ];

        foreach ($formularios as $formulario) {
            $user = Formulario::create($formulario['formulario_data']);
        }
    }
}
