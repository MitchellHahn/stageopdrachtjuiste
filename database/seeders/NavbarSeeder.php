<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navbar;

class NavbarSeeder extends Seeder
{
    /**
     * Seeder voor (mijn profiel, ingevoegde uren, gemaakte facturen, uren en toeslag toevoegen) navbar ZZPer
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'MijnProfiel',
                'route' => 'BProfiel',
                'ordering' => 1,
            ],

            [
                'name' => 'IngevoegdeUren',
                'route' => 'IngevoegdeUren.index',
                'ordering' => 2,
            ],

            [
                'name' => 'GemaakteFacturen',
                'route' => 'GemaakteFacturen.index',
                'ordering' => 3,
            ],

            [
                'name' => 'Toevoegen',
                'route' => 'UToevoegen.overzicht_gewerkte_dagen',
                'ordering' => 4,
            ]
        ];

        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}
