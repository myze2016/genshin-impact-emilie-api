<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PartyPositionCharacter;
use Illuminate\Support\Facades\Log;
use App\Models\PartyWeapon;
use App\Models\PartyArtifact;
use App\Models\Character;

class PartyPositionCharacterController extends Controller
{
    public function index(Request $request) {
        $party_positions = PartyPositionCharacter::all();
        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Position Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {

         $recentCharacter = PartyPositionCharacter::orderBy('value', 'ASC')->first();

        $value = $recentCharacter ? $recentCharacter->value - 1 : 100;
        $request->merge(['value' => $value]);
        $party_positions = PartyPositionCharacter::create($request->all());

        $characterId = $request->character_id;
        $character = Character::where('id', $characterId)->with('weapons')->with('artifacts')->first();
        Log::info('character', ['character', $character]);

        foreach ($character->artifacts as $artifact) {
            $party_artifacts = PartyArtifact::create([
                'artifact_id' => $artifact->artifact_id,
                'party_character_id' => $party_positions->id, 
            ]);
        }

        foreach ($character->weapons as $weapon) {
              $party_weapons = PartyWeapon::create([
                'weapon_id' => $weapon->weapon_id,
                'party_character_id' => $party_positions->id, 
            ]);
        }


        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Position Added Successfully'
        ], 200);
    }


    public function arrange(Request $request)
    {
        $movingItem = PartyPositionCharacter::findOrFail($request->id);
     
        $targetItem = PartyPositionCharacter::where('value', $movingItem->value - 1)
            ->first();

        if (!$targetItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot move character.',
            ], 400);
        }

        $tempValue = $movingItem->value;

        $movingItem->update(['value' => $targetItem->value]);
        $targetItem->update(['value' => $tempValue]);

        return response()->json([
            'success' => true,
            'message' => 'Positions swapped successfully',
        ]);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request, $id) {
         try {
            $character = PartyPositionCharacter::where('id', $id)
            ->delete();
            return response()->json([
                'perk' => $character,
                'success' => true,
                'message' => 'Character Deleted Successfully'
            ], 200);
         } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 500
            ], 500);
        }
    }
}
