<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;
use App\Models\WeaponType;
use App\Models\PartyPositionCharacter;

class CharacterController extends Controller
{
    public function index(Request $request) {
        $characters = Character::with('element')->with('weapons.weapon.perks.perk')->with('artifacts.artifact.perks.perk')->with('weapon_type')->where('name', 'LIKE', '%'.$request->search.'%')->orWhereHas('element', function ($subQ1) use ($request) {
                $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->orWhereHas('weapons', function ($q) use ($request) {
            $q->whereHas('weapon', function ($subQ) use ($request) {
                $subQ->whereHas('perks', function ($subQ2) use ($request) {
                    $subQ2->whereHas('perk', function ($subQ3) use ($request) {
                        $subQ3->where('name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                    });
                });
            });
        })->orWhereHas('artifacts', function ($q) use ($request) {
            $q->whereHas('artifact', function ($subQ) use ($request) {
                $subQ->whereHas('perks', function ($subQ2) use ($request) {
                    $subQ2->whereHas('perk', function ($subQ3) use ($request) {
                        $subQ3->where('name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                    });
                });
            });
        })->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Fetched Successfully'
        ], 200);
    }

    public function searchName(Request $request) {
        $characters = Character::with('element')->where('name', 'LIKE', '%'.$request->search.'%')->with('weapon_type')->with('weapons.weapon.perks.perk')->with('artifacts.artifact.perks.perk')->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Fetched Successfully'
        ], 200);
    }


      public function getCharacterArtitactUser(Request $request) {
        $characters = PartyPositionCharacter::with('party_position.party.users')->with('party_weapon.weapon')->with('party_artifact')->whereHas('party_artifact', function($q) use ($request) {
            $q->where('artifact_id', $request->artifact_id);
        })->whereHas('party_position.party.users', function($q) use ($request) {
            $q->where('user_id', auth('sanctum')->id());
        })->with('character.element')->with('character.perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'characters' => $characters,
            'id' => $request->artifact_id,
            'success' => true,
            'message' => 'Character Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $characterExist = Character::where('name', $request->name)->first();
        if ($characterExist) {
            return response()->json([
                'characters' => $characterExist,
                'success' => true,
                'message' => 'Character Exist'
            ], 500);
        }
        $characters = Character::create($request->all());
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request,) {
         try {
            $character = Character::where('id', $id)
            ->delete();
            return response()->json([
                'perk' => $character,
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


    public function addCharacterApi(Request $request) {
        try {
            $characters = Http::retry(3, 200)->get('https://genshin.jmp.blue/characters')->json();
            $elements = Element::get();
            $weaponTypes = WeaponType::get();
            $characterApis = Character::get();
            $characterCount = Character::whereNotNull('api_id')->count();
            $characterCollect = collect($characters);
            $remainingCharacters = $characterCollect->slice($characterCount)->values();
            foreach ($remainingCharacters as $character) {
                
                $matchedApi = $characterApis->first(function ($characterApi) use ($character) {
                    return strtolower($characterApi->api_id) === $character;
                });

                if (!$matchedApi) {
                    
                    $characterInfo = Http::retry(3, 200)->get('https://genshin.jmp.blue/characters/'.$character)->json();
                      
                    $characterExist = Character::where('name', $characterInfo['name'])->first();
                    $imgUrl = 'https://genshin.jmp.blue/characters/';
                  
                    if (!$characterExist) {
                        $vision = strtolower($characterInfo['vision']);
                        $matchedElement = $elements->first(function ($element) use ($vision) {
                            return strtolower($element->name) === $vision;
                        });

                        $elementId = $matchedElement ? $matchedElement->id : null;

                        $weapon = strtolower($characterInfo['weapon']);
                        $matchedWeapon = $weaponTypes->first(function ($weaponType) use ($weapon) {
                            return strtolower($weaponType->name) === $weapon;
                        });

                        $weaponTypeId = $matchedWeapon ? $matchedWeapon->id : null;

                        Character::create([
                            'name' => $characterInfo['name'],
                            'element_id' => $elementId,
                            'weapon_type_id' => $weaponTypeId,
                            'api_id' => $character,
                            'gacha_card_url' => $imgUrl.$character.'/gacha-card.png',
                            'gacha_splash_url' => $imgUrl.$character.'/gacha-splash.png',
                            'icon_url' => $imgUrl.$character.'/icon.png',
                            'icon_side_url' => $imgUrl.$character.'/icon-side.png',
                            'namecard_background_url' => $imgUrl.$character.'/namecard-background.png',
                        ]);
                    } 
                } 
            }
            
            return response()->json([
                'elements' => $elements,
                'success' => true,
                'message' => 'Character Added Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
