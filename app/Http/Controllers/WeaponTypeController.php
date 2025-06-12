<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeaponType;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeaponTypeController extends Controller
{
    public function index(Request $request) {
        $weapon_types = WeaponType::get();
        return response()->json([
            'weapon_types' => $weapon_types,
            'success' => true,
            'message' => 'Weapon Types Fetched Successfully'
        ], 200);
    }

}
