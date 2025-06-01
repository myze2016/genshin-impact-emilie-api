<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

class PartyController extends Controller
{
    public function index(Request $request) {
        $parties = Party::with('positions.characters_value')->get();
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $parties = Party::create($request->all());
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
        
    }
}
