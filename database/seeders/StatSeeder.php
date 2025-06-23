<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'name' => 'Offset',
                'description' => '',
            ],
             [
                'name' => 'Elemental Mastery',
                'description' => '',
            ],
             [
                'name' => 'Def%',
                'description' => '',
            ],
            [
                'name' => 'Def+',
                'description' => '',
            ],
            [
                'name' => 'HP%',
                'description' => '',
            ],
            [
                'name' => 'HP+',
                'description' => '',
            ],
            [
                'name' => 'Attack%',
                'description' => '',
            ],
            [
                'name' => 'Attack+',
                'description' => '',
            ],
             [
                'name' => 'Energy Recharge',
                'description' => '',
            ],
             [
                'name' => 'Crit Rate',
                'description' => '',
            ],
            [
                'name' => 'Crit Damage',
                'description' => '',
            ],
             [
                'name' => 'Physical Damage Bonus',
                'description' => '',
            ],
             [
                'name' => 'Cryo Damage Bonus',
                'description' => '',
            ],
             [
                'name' => 'Pyro Damage Bonus',
                'description' => '',
            ],
              [
                'name' => 'Hydro Damage Bonus',
                'description' => '',
            ],
              [
                'name' => 'Dendro Damage Bonus',
                'description' => '',
            ],
            [
                'name' => 'Electro Damage Bonus',
                'description' => '',
            ],
            [
                'name' => 'Geo Damage Bonus',
                'description' => '',
            ],
            [
                'name' => 'Anemo Damage Bonus',
                'description' => '',
            ],
        ];

        foreach ($stats as $stat) {
            Stat::create($stat);
        }
    }
}
