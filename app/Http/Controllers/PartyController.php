<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PartyUser;
use Illuminate\Support\Facades\Log;

class PartyController extends Controller
{
    public function index(Request $request) {
       $parties = Party::with([
            'positions.characters_value.character.perks.perk.common',
            'users',
            'element',
            'character.element'
        ])
        ->doesntHave('users') // only get parties with NO users
        ->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('reaction', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('character', function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('element', function ($q3) use ($request) {
                    $q3->where('name', 'LIKE', '%' . $request->search . '%');
                });
        })
        ->orderBy('element_id', 'DESC')
        ->orderBy('character_id', 'DESC')
        ->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }

    public function getPartiesUser(Request $request) {
        Log::info('login', ['login' => auth('sanctum')->user()->id]);
        $parties = Party::with([
            'positions.characters_value.character.perks.perk.common',
            'users',
            'element',
            'character.element',
            'copied_from'
        ])
        ->whereHas('users', function ($q4) {
            $q4->where('user_id', auth('sanctum')->id());
        })
        ->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('reaction', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('character', function ($subQ1) use ($request) {
                    $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
                })
                ->orWhereHas('element', function ($subQ1) use ($request) {
                    $subQ1->where('name', 'LIKE', '%' . $request->search . '%');
                });
        })
        ->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }

    public function show(Request $request, $id) {
        $parties = Party::with('positions.characters_value.character.perks.perk.common')->with('copied_from')->with('positions.characters_value.party_weapon.weapon.perks.perk.common')->with('positions.characters_value.party_artifact.artifact.perks.perk.common')->with('positions.characters_value.character.weapons.weapon.perks.perk.common')->with('positions.characters_value.character.artifacts.artifact.perks.perk.common')->with('element')->with('character')->where('id', $id)->get();
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Fetched Successfully'
        ], 200);
    }


    public function addPartyImage(Request $request) {
        
        $party = Party::where('id', $request->party_id)->update([
            'character_id' => $request->character_id,
        ]);
        return response()->json([
            'party' => $party,
            'success' => true,
            'message' => 'Party Image Added Successfully'
        ], 200);
    }

    public function store(Request $request) {
        $parties = Party::create($request->all());
        return response()->json([
            'parties' => $parties,
            'success' => true,
            'message' => 'Party Added Successfully'
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        $party = Party::where('id', $id)->update( $request->except(['id']) );
        return response()->json([
            'party' => $party,
            'success' => true,
            'message' => 'Party Image Added Successfully'
        ], 200);
    }

    public function destroy(Request $request, $id) {
         try {
            $party = Party::where('id', $id)
            ->delete();
            return response()->json([
                'party' => $party,
                'success' => true,
                'message' => 'Party Deleted Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 500
            ], 500);
        }
    }

    public function copyParty(Request $request)
{
    $originalParty = Party::with('positions.characters')->with('positions.characters.party_weapon')->with('positions.characters.party_artifact')->find($request->id);

    if (!$originalParty) {
        return response()->json([
            'success' => false,
            'message' => 'Original party not found.'
        ], 500);
    }

    $copiedParty = $originalParty->replicate();      
    $copiedParty->copied_from_id = $originalParty->id; 
    $copiedParty->save();

    PartyUser::create([
        'party_id' => $copiedParty->id,
        'user_id' => auth('sanctum')->user()->id,
    ]);

    foreach ($originalParty->positions as $position) {
        $copiedPosition = $position->replicate();
        $copiedPosition->party_id = $copiedParty->id;
        $copiedPosition->save();

        // Copy characters (assuming this is a hasMany on Position)
        foreach ($position->characters as $characterValue) {
            $copiedCharacter = $characterValue->replicate();
            $copiedCharacter->party_position_id = $copiedPosition->id;
            $copiedCharacter->save();

            foreach ($characterValue->party_weapon as $weapon) {
                $copiedWeapon = $weapon->replicate();
                $copiedWeapon->party_character_id = $copiedCharacter->id;
                $copiedWeapon->save();
            }
            
            foreach ($characterValue->party_artifact as $artifact) {
                $copiedArtifact = $artifact->replicate();
                $copiedArtifact->party_character_id = $copiedCharacter->id;
                $copiedArtifact->save();
                
                foreach ($artifact->party_artifact_piece as $piece) {
                    $copiedPiece = $piece->replicate();
                    $copiedPiece->party_artifact_id = $copiedArtifact->id;
                    $copiedPiece->save();
                }
            }
            
        }
    }

    return response()->json([
        'party' => $copiedParty,
        'success' => true,
        'message' => 'Party copied successfully.'
    ]);
}

    public function refetchAbyss(Request $request) {

        $perkNames = collect($request->perks)->pluck('name')->toArray();
        if ($request->select === 'party') {
            Log::info('perkNames', ['perkNames' => $perkNames]);
            $parties = Party::with([
                'positions.characters_value.character.perks.perk',
                'users',
                'element',
                'character.element'
            ])
            ->doesntHave('users') 
            ->where('reaction', 'LIKE', '%' . $request->reaction . '%')
            ->where('element_id', 'LIKE', '%' . $request->element_id . '%')
            ->when($perkNames, function ($query) use ($perkNames) {
                $query->whereHas('positions.characters_value.character.perks.perk', function ($q2) use ($perkNames) {            
                    $q2->whereIn('name', $perkNames);
                });
            })
            ->paginate($request->rows_per_page ?? 10);
            return response()->json([
                'data' => $parties,
                'success' => true,
                'message' => 'Party Fetched Successfully'
            ], 200);
        } else {
            $parties = Party::with([
                'positions.characters_value.character.perks.perk',
                'users',
                'element',
                'character.element'
            ])
            ->whereHas('users', function ($q4) {
                $q4->where('user_id', auth('sanctum')->id());
            })
            ->where('reaction', 'LIKE', '%' . $request->reaction . '%')
            ->where('element_id', 'LIKE', '%' . $request->element_id . '%')
            ->when($perkNames, function ($query) use ($perkNames) {
                $query->whereHas('positions.characters_value.character.perks.perk', function ($q2) use ($perkNames) {            
                    $q2->whereIn('name', $perkNames);
                });
            })
            ->paginate($request->rows_per_page ?? 10);
            return response()->json([
                'data' => $parties,
                'success' => true,
                'message' => 'Party Fetched Successfully'
            ], 200);
        }
    }
    
}
