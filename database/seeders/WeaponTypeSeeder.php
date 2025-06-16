<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WeaponType;

class WeaponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weaponTypes = [
            [
                'name' => 'Sword',
                'color' => '#8b3a2f'
            ],
            [
                'name' => 'Polearm',
                'color' => '#7a6652'
            ],
            [
                'name' => 'Claymore',
                'color' => '#5e4b8b'
            ],
            [
                'name' => 'Bow',
                'color' => '#486b45'
            ],
             [
                'name' => 'Catalyst',
                'color' => '#336b87'
            ],
        ];

        foreach ($weaponTypes as $weaponType) {
            WeaponType::create($weaponType);
        }
    }
}
