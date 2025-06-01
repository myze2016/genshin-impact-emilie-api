<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index(Request $request) {
        $characters = Character::with('perks')->get();
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $characters = Character::create($request->all());
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
        
    }
}
