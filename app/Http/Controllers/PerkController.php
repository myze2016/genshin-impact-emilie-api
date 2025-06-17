<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Perk;

class PerkController extends Controller
{
    public function index(Request $request) {
        $perks = Perk::where('name', 'LIKE', '%'.$request->search.'%')->orWhere('description', 'LIKE', '%'.$request->search.'%')->orderBy('created_at', 'DESC')->paginate($request->rows_per_page ?? 5);
      
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
            $exists = Perk::where('name', $request->name)->first();

            if ($exists) {
                return response()->json(['error' => 'Perk with this name already exists.'], 500);
            }
            $perks = Perk::create($request->all());
            return response()->json([
                'perks' => $perks,
                'success' => true,
                'message' => 'Perk Added Successfully'
            ], 200);
         } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 500
            ], 500);
        }
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request, $id) {
         try {
            $perk = Perk::where('id', $id)
            ->delete();
            return response()->json([
                'perk' => $perk,
                'success' => true,
                'message' => 'Perk Deleted Successfully'
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
