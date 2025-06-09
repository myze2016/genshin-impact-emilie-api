<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PartyPositionCharacter;
use Illuminate\Support\Facades\Log;

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
        Log::info('value', ['value' => $value]);
        $request->merge(['value' => $value]);
        $party_positions = PartyPositionCharacter::create($request->all());
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
