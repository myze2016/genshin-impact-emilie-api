<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Perk;

class PerkController extends Controller
{
    public function index(Request $request) {
        $perks = Perk::where('name', 'LIKE', '%'.$request->search.'%')->orWhere('description', 'LIKE', '%'.$request->search.'%')->orderBy('created_at', 'DESC')->get();
      
        return response()->json([
            'perks' => $perks,
            'success' => true,
            'message' => 'Perk Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        try {
            $perks = Perk::create($request->all());
            return response()->json([
                'parties' => $perks,
                'success' => true,
                'message' => 'Perk Added Successfully'
            ], 200);
         } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add perk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
        
    }
}
