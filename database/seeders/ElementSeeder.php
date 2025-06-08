<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Element;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elements = [
            [
                'name' => 'Anemo',
                'image_url' => 'https://genshin.jmp.blue/elements/anemo/icon.png',
                'color' => '#8b3a2f'
            ],
            [
                'name' => 'Geo',
                'image_url' => 'https://genshin.jmp.blue/elements/geo/icon.png',
                'color' => '#7a6652'
            ],
            [
                'name' => 'Electro',
                'image_url' => 'https://genshin.jmp.blue/elements/electro/icon.png',
                'color' => '#5e4b8b'
            ],
            [
                'name' => 'Dendro',
                'image_url' => 'https://genshin.jmp.blue/elements/dendro/icon.png',
                'color' => '#486b45'
            ],
             [
                'name' => 'Hydro',
                'image_url' => 'https://genshin.jmp.blue/elements/hydro/icon.png',
                'color' => '#336b87'
            ],
             [
                'name' => 'Pyro',
                'image_url' => 'https://genshin.jmp.blue/elements/pyro/icon.png',
                'color' => '#8b3a2f'
            ],
            [
                'name' => 'Cryo',
                'image_url' => 'https://genshin.jmp.blue/elements/cryo/icon.png',
                'color' => '#4a707a'
            ],
        ];

        foreach ($elements as $element) {
            Element::create($element);
        }
    }
}
