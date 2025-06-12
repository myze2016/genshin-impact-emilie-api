<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CharacterPerk;
use App\Models\Perk;
use App\Models\WeaponPerk;
use App\Models\Weapon;

class WeaponPerkController extends Controller
{
    public function index(Request $request) {
       $perks = Perk::with(['weapon_perks' => function ($query) use ($request) {
            $query->where('weapon_id', $request->weapon_id);
        }])
        ->withCount(['weapon_perks as related_perks_count' => function ($query) use ($request) {
            $query->where('weapon_id', $request->weapon_id);
        }])
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->orderByDesc('related_perks_count')
        ->paginate($request->rows_per_page ?? 10);

        return response()->json([
            'weapon_perks' => $perks,
            'success' => true,
            'message' => 'Weapon Perks Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $weaponPerks = WeaponPerk::create($request->all());
        return response()->json([
            'weapon_perks' => $weaponPerks,
            'success' => true,
            'message' => 'Party Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request, $id) {
    
    }

     public function deleteWeaponPerkByPerk(Request $request) {
        $weaponPerks = WeaponPerk::where('weapon_id', $request->weapon_id)
            ->where('perk_id', $request->perk_id)
            ->delete();
        return response()->json([
            'weapon_perks' => $weaponPerks,
            'success' => true,
            'message' => 'Perk Deleted Successfully'
        ], 200);
    }
}
