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
                    'nombre' => 'Registro Mesas de trabajo',
                    'slug' => 'registro-mesa-trabajo-ley-intregracion-personas-discapacidad',
                    'descripcion' => 'Registro de parcitipantes a las Mesas de trabajo para analizar la Ley para la Integración de las Personas con Discapacidad del Estado de Veracruz',
                    'configuracion' => [
                        'APP_LOGO' => 'https://legisver.gob.mx/img/LOGO_LXVII_SLOGAN.jpg',
                        'APP_SLOGAN' => 'Congreso del Estado de Veracruz',
                        'APP_URL_LINK' => 'https://legisver.gob.mx/avisodeprivacidad/AvisoIntegralRegistroIPD.pdf',
                        'APP_TITLE_LINK' => 'Aviso de privacidad',

                        'HEADER_CONFIG' => [
                            'text_title_color' => '#241F31',
                            'type' => 'multicolor',
                            'solid_color' => '#DEDDDA',
                            'gradient_start' => '#9a9996',
                            'gradient_end' => '#deddda',
                            'multicolor_1' => '#C0BFBC',
                            'multicolor_2' => '#F6F5F4',
                            'multicolor_3' => '#C0BFBC',
                            'text_footer_color' => '#3D3846',
                            'footer_color' => '#DEDDDA',
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
