<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CharacterPerk;
use App\Models\Perk;
use App\Models\CharacterWeapon;

class CharacterWeaponController extends Controller
{
    public function index(Request $request) {
       $perks = Perk::with(['character_perks' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])
        ->withCount(['character_perks as related_perks_count' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->orderByDesc('related_perks_count')
        ->paginate($request->rows_per_page ?? 10);

        return response()->json([
            'character_perks' => $perks,
            'success' => true,
            'message' => 'Character Perk Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $characterWeapon = CharacterWeapon::create($request->all());
        return response()->json([
            'character_weapon' => $characterWeapon,
            'success' => true,
            'message' => 'Weapon Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
    }

    public function deleteWeaponByCharacter(Request $request) {
        $characterWeapon = CharacterWeapon::where('character_id', $request->character_id)
            ->where('weapon_id', $request->weapon_id)
            ->delete();
        return response()->json([
            'characterWeapon' => $characterWeapon,
            'success' => true,
            'message' => 'Weapon Deleted Successfully'
        ], 200);
    }
}
