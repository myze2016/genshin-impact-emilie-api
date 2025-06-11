<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weapon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;

class WeaponController extends Controller
{
    public function index(Request $request) {
        $weapons = Weapon::where('name', 'LIKE', '%'.$request->search.'%')->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'weapons' => $weapons,
            'success' => true,
            'message' => 'Weapon Fetched Successfully'
        ], 200);
    }

    public function searchByPerk(Request $request) {
        $weapons = Weapon::where('name', 'LIKE', '%'.$request->search.'%')->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'weapons' => $weapons,
            'success' => true,
            'message' => 'Weapon Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $weaponExist = Weapon::where('name', $request->name)->first();
        if ($weaponExist) {
            return response()->json([
                'weapons' => $weaponExist,
                'success' => true,
                'message' => 'Weapon Exist'
            ], 500);
        }
        $weapon = Weapon::create($request->all());
        return response()->json([
            'weapon' => $weapon,
            'success' => true,
            'message' => 'Weapon Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request,) {
         try {
            $weapon = Weapon::where('id', $id)
            ->delete();
            return response()->json([
                'weapon' => $weapon,
                'success' => true,
                'message' => 'Weapon Deleted Successfully'
            ], 200);
         } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 500
            ], 500);
        }
    }


    public function addWeaponsApi(Request $request) {
        try {
            $weapons = Http::retry(3, 200)->get('https://genshin.jmp.blue/weapons')->json();
            foreach ($weapons as $weapon) {
                
                $apiIdExist = Weapon::where('api_id', $weapon)->first();
    
                if (!$apiIdExist) {
                    
                    $weaponInfo = Http::retry(3, 200)->get('https://genshin.jmp.blue/weapons/'.$weapon)->json();
                      
                    $weaponExist = Weapon::where('name', $weaponInfo['name'])->first();
                    $imgUrl = 'https://genshin.jmp.blue/weapons/';
                    if (!$weaponExist) {
                        Weapon::create([
                            'name' => $weaponInfo['name'],
                        ]);
                    } 
                } 
            }
            
            return response()->json([
                'weaponInfo' => $weaponInfo,
                'success' => true,
                'message' => 'Weapons Added Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
