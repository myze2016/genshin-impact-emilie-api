<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;

class CharacterController extends Controller
{
    public function index(Request $request) {
        $characters = Character::with('element')->where('name', 'LIKE', '%'.$request->search.'%')->orWhereHas('element', function ($subQ1) use ($request) {
                $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'characters' => $characters,
            'success' => true,
            'message' => 'Character Fetched Successfully'
        ], 200);
    }

    public function searchName(Request $request) {
        $characters = Character::with('element')->where('name', 'LIKE', '%'.$request->search.'%')->with('perks.perk')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'characters' => $characters,
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

    public function destroy(Request $request) {
        
    }


    public function addCharacterApi(Request $request) {
        try {
            $characters = Http::retry(3, 200)->get('https://genshin.jmp.blue/characters')->json();
            foreach ($characters as $character) {
                
                $apiIdExist = Character::where('api_id', $character)->first();
    
                if (!$apiIdExist) {
                    
                    $characterInfo = Http::retry(3, 200)->get('https://genshin.jmp.blue/characters/'.$character)->json();
                      
                    $characterExist = Character::where('name', $characterInfo['name'])->first();
                    $imgUrl = 'https://genshin.jmp.blue/characters/';
                    $elements = Element::get();
                    if (!$characterExist) {
                        $vision = strtolower($characterInfo['vision']);
                        $matchedElement = $elements->first(function ($element) use ($vision) {
                            return strtolower($element->name) === $vision;
                        });

                        $elementId = $matchedElement ? $matchedElement->id : null;

                        Character::create([
                            'name' => $characterInfo['name'],
                            'element_id' => $elementId,
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
