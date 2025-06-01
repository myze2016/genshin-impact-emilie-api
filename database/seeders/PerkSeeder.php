<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perk;

class PerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $perks = [
            [
                'name' => 'Infusion Pyro',
                'description' => 'Increases fire damage by 20%.',
            ],
            [
                'name' => 'Heal',
                'description' => 'Grants a shield that absorbs water damage.',
            ],
        ];

        foreach ($perks as $perk) {
            Perk::create($perk);
        }
    }
}
