<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CharacterPerk;
use App\Models\Perk;
use App\Models\WeaponPerk;
use App\Models\Weapon;
use App\Models\PartyWeapon;

class PartyWeaponController extends Controller
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
        $partyWeapon = PartyWeapon::create($request->all());
        return response()->json([
            'party_weapon' => $partyWeapon,
            'success' => true,
            'message' => 'Weapon Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request, $id) {
        $partyWeapon = PartyWeapon::destroy($id);
        return response()->json([
            'party_weapon' => $partyWeapon,
            'success' => true,
            'message' => 'Weapon Deleted Successfully'
        ], 200);
    
    }

     public function deleteWeaponByPartyCharacterId(Request $request) {
        $partyWeapon = PartyWeapon::where('weapon_id', $request->weapon_id)
            ->where('party_character_id', $request->party_character_id)
            ->delete();
        return response()->json([
            'party_weapon' => $partyWeapon,
            'success' => true,
            'message' => 'Weapon Deleted Successfully'
        ], 200);
    }
}
