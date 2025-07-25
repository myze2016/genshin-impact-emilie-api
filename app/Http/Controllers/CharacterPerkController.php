<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CharacterPerk;
use App\Models\Perk;

class CharacterPerkController extends Controller
{
    public function index(Request $request) {
       $perks = Perk::with(['character_perks' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])
        ->withCount(['character_perks as related_perks_count' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])
        ->where('type', 'LIKE', '%' . $request->type . '%')
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
        $characterPerks = CharacterPerk::create($request->all());
        return response()->json([
            'character_perks' => $characterPerks,
            'success' => true,
            'message' => 'Party Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
    }

    public function deletePerkByCharacter(Request $request) {
        $characterPerk = CharacterPerk::where('character_id', $request->character_id)
            ->where('perk_id', $request->perk_id)
            ->delete();
        return response()->json([
            'character_perks' => $characterPerk,
            'success' => true,
            'message' => 'Perk Deleted Successfully'
        ], 200);
    }
}
