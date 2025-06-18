<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PartyPosition;

class PartyPositionController extends Controller
{
    public function index(Request $request) {
        $party_positions = PartyPosition::all();
        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Position Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $party_positions = PartyPosition::create($request->all());
        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Position Added Successfully'
        ], 200);
    }

    public function update(Request $request,$id) {
        $party_positions = PartyPosition::where('id', $id)->update( $request->all() );
        return response()->json([
            'party_positions' => $party_positions,
            'success' => true,
            'message' => 'Party Image Position Successfully'
        ], 200);
    }

    public function destroy(Request $request, $id) {
        try {
            $position = PartyPosition::where('id', $id)
            ->delete();
            return response()->json([
                'position' => $position,
                'success' => true,
                'message' => 'Position Successfully'
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
