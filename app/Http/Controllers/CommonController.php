<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Perk;
use App\Models\Common;

class CommonController extends Controller
{
    public function index(Request $request) {
        $commons = Common::where('name', 'LIKE', '%'.$request->search.'%')->get();
        return response()->json([
            'commons' => $commons,
            'success' => true,
            'message' => 'Commons Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        try {
            $commonExist = Common::where('name', $request->name)->first();
            if ($commonExist) {
                return response()->json([
                'success' => false,
                'message' => 'Common Exist',
                'error' => 'exist error'
                ], 500);
            }
            $common = Common::create($request->all());
            return response()->json([
                'common' => $common,
                'success' => true,
                'message' => 'Common Added Successfully'
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
