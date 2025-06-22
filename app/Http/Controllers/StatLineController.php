<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Perk;
use App\Models\Stat;
use App\Models\StatLine;
use App\Models\StatLineSubstat;
use Illuminate\Support\Facades\Log;

class StatLineController extends Controller
{
    public function index(Request $request) {
        $stats = Stat::where('name', 'LIKE', '%'.$request->search.'%')->orWhere('description', 'LIKE', '%'.$request->search.'%')->orderBy('created_at', 'DESC')->paginate($request->rows_per_page ?? 5);
      
        return response()->json([
            'stats' => $stats,
            'success' => true,
            'message' => 'Stats Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        try {
            
            
            $stat_lines = StatLine::create($request->except(['substat']));

            foreach ($request->substat as $statId) {
                StatLineSubstat::create([
                    'stat_line_id' => $stat_lines->id,
                    'stat_id' => $statId,
                ]);
            }
            return response()->json([
                'stat_lines' => $stat_lines,
                'requests' => $request,
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
