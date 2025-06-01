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
            $query->where('character_id', $request->character_id)->get();
        }])->get()->sortByDesc(function ($perk) {
            return $perk->character_perks->isNotEmpty(); 
        })
        ->values();
        return response()->json([
            'character_perks' => $perks,
            'success' => true,
            'message' => 'Party Fetched Successfully'
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
}
