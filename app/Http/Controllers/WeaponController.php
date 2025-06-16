<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weapon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;
use App\Models\WeaponType;

class WeaponController extends Controller
{
    public function index(Request $request) {
        $weapons = Weapon::where('name', 'LIKE', '%'.$request->search.'%')->with('weapon_type')->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'weapons' => $weapons,
            'success' => true,
            'message' => 'Weapon Fetched Successfully'
        ], 200);
    }

    public function searchByPerk(Request $request) {
        $weapons = Weapon::where('name', 'LIKE', '%'.$request->search.'%')->with(['character_weapon' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])->with('weapon_type')->where('weapon_type_id', $request->weapon_type_id)->orWhereHas('perks', function ($q) use ($request) {
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

     public function getWeaponByParty(Request $request) {
        $weapons = Weapon::where('name', 'LIKE', '%'.$request->search.'%')->with('character_weapon')->with(['party_weapon' => function ($query) use ($request) {
            $query->where('party_character_id', $request->party_character_id);
        }])->with('weapon_type')->where('weapon_type_id', $request->weapon_type_id)->orWhereHas('perks', function ($q) use ($request) {
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
            $weaponTypes = WeaponType::get();
            $weaponApis = Weapon::get();
            $weaponCount = Weapon::whereNotNull('api_id')->count();
            $weaponsCollect = collect($weapons);
            $remainingWeapons = $weaponsCollect->slice($weaponCount)->values();
            foreach ($remainingWeapons as $weapon) {
                $matchedApi = $weaponApis->first(function ($weaponApi) use ($weapon) {
                        return strtolower($weaponApi->api_id) === $weapon;
                    });
                if (!$matchedApi) {
                    $weaponInfo = Http::retry(3, 200)->get('https://genshin.jmp.blue/weapons/'.$weapon)->json();
                    $weaponExist = Weapon::where('name', $weaponInfo['name'])->first();
                    $imgUrl = 'https://genshin.jmp.blue/weapons/';
                
                    if (!$weaponExist) {
                        $type = strtolower($weaponInfo['type']);
                        $matchedType = $weaponTypes->first(function ($weaponType) use ($type) {
                            return strtolower($weaponType->name) === $type;
                        });

                        $weaponTypeId = $matchedType ? $matchedType->id : null;


                        Weapon::create([
                            'name' => $weaponInfo['name'],
                            'api_id' => $weapon,
                            'weapon_type_id' => $weaponTypeId,
                        ]);
                    } 
                } 
                
            }
            
            return response()->json([
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
