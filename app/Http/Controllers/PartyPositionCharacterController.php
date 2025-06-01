<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PartyPositionCharacter;

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
        $party_positions = PartyPositionCharacter::create($request->all());
        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Position Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
        
    }
}
