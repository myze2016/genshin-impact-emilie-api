<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

class PartyController extends Controller
{
    public function index(Request $request) {
        $parties = Party::with('positions.characters_value.character.perks.perk')->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('reaction', 'LIKE', '%'.$request->search.'%')->orWhereHas('character', function ($subQ1) use ($request) {
                $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('element', function ($subQ1) use ($request) {
                $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
            })->with('element')->with('character.element')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }

    public function show(Request $request, $id) {
        $parties = Party::with('positions.characters_value.character.perks.perk')->with('element')->with('character')->where('id', $id)->get();
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }


    public function addPartyImage(Request $request) {
        
        $party = Party::where('id', $request->party_id)->update([
            'character_id' => $request->character_id,
        ]);
        return response()->json([
            'party' => $party,
            'success' => true,
            'message' => 'Party Image Added Successfully'
        ], 200);
    }

    public function store(Request $request) {
        $parties = Party::create($request->all());
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Added Successfully'
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        $party = Party::where('id', $id)->update( $request->except(['id']) );
        return response()->json([
            'party' => $party,
            'success' => true,
            'message' => 'Party Image Added Successfully'
        ], 200);
    }

    public function destroy(Request $request) {
        
    }
}
