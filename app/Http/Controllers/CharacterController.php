<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CharacterController extends Controller
{
    public function index(Request $request) {
        $characters = Character::where('name', 'LIKE', '%'.$request->search.'%')->orWhere('element', 'LIKE', '%'.$request->search.'%')->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->with('perks.perk')->get();
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
            $characters = Http::get('https://genshin.jmp.blue/characters')->json();

            foreach ($characters as $character) {
                
                $apiIdExist = Character::where('api_id', $character)->first();
    
                if (!$apiIdExist) {
                    
                    $characterInfo = Http::get('https://genshin.jmp.blue/characters/'.$character)->json();
                      
                    $characterExist = Character::where('name', $characterInfo['name'])->first();
                    
                    if (!$characterExist) {
                        Character::create([
                            'name' => $characterInfo['name'],
                            'element' => $characterInfo['vision'],
                            'api_id' => $character,
                        ]);
                    } else {
                        Character::where('id', $characterExist->id)->update([
                            'name' => $characterInfo['name'],
                            'element' => $characterInfo['vision'],
                            'api_id' => $character,
                        ]);
                    }
                } 
            }
            
            return response()->json([
                'characterList' => $response,
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
