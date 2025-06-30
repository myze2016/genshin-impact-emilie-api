<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;
use App\Models\Artifact;
use App\Models\Perk;
use App\Models\CharacterArtifact;
use Illuminate\Support\Str;

class ArtifactController extends Controller
{
     public function index(Request $request) {
        $artifacts = Artifact::where('name', 'LIKE', '%'.$request->search.'%')->with('perks.perk.common')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'artifacts' => $artifacts,
            'success' => true,
            'message' => 'Artifacts Fetched Successfully'
        ], 200);
    }

      public function getArtifactUser(Request $request) {
        $artifacts = Artifact::where('name', 'LIKE', '%'.$request->search.'%')->with('perks.perk')->with('party_artifact.party_character.party_position.party.users')
        ->whereHas('party_artifact.party_character.party_position.party.users', function ($query) use ($request) {
            $query->where('user_id', auth('sanctum')->user()->id);
        })->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'artifacts' => $artifacts,
            'success' => true,
            'message' => 'Artifacts Fetched Successfully'
        ], 200);
    }


    public function searchByPerk(Request $request) {
        $artifacts = Artifact::where('name', 'LIKE', '%'.$request->search.'%')->with(['character_artifact' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->with('perks.perk')->withCount(['character_artifact as related_artifact_count' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])->orderByDesc('related_artifact_count')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'artifacts' => $artifacts,
            'success' => true,
            'message' => 'Artifacts Fetched Successfully'
        ], 200);
    }


    public function getArtifactByParty(Request $request) {
        $artifacts = Artifact::withCount(['character_artifact' => function ($query) use ($request) {
            $query->where('character_id', $request->character_id);
        }])->withCount(['party_artifact' => function ($query) use ($request) {
        $query->where('party_character_id', $request->party_character_id);
    }])->where('name', 'LIKE', '%'.$request->search.'%')->with('character_artifact')->with(['party_artifact' => function ($query) use ($request) {
            $query->with(['stat_line.sands_stat', 'stat_line.goblet_stat', 'stat_line.circlet_stat', 'stat_line.sub_stat.stat', 'party_artifact_piece.stat'])->where('party_character_id', $request->party_character_id);
        }])->orWhereHas('perks', function ($q) use ($request) {
            $q->whereHas('perk', function ($subQ) use ($request) {
                $subQ->where('name', 'LIKE', '%' . $request->search . '%')
                     ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        })->with('perks.perk')->orderByDesc('character_artifact_count')->orderByDesc('party_artifact_count')->paginate($request->rows_per_page ?? 10);
        return response()->json([
            'artifacts' => $artifacts,
            'success' => true,
            'message' => 'Artifacts Fetched Successfully'
        ], 200);
    }
    

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $artifactExist = Artifact::where('name', $request->name)->first();
        if ($artifactExist) {
            return response()->json([
                'artifacts' => $artifactExist,
                'success' => true,
                'message' => 'Artifact Exist'
            ], 500);
        }
        $artifact = Artifact::create($request->all());
        return response()->json([
            'artifact' => $artifact,
            'success' => true,
            'message' => 'Artifact Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request,) {
         try {
            $artifact = Artifact::where('id', $id)
            ->delete();
            return response()->json([
                'artifact' => $artifact,
                'success' => true,
                'message' => 'Artifact Deleted Successfully'
            ], 200);
         } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 500
            ], 500);
        }
    }


    public function addArtifactsApi(Request $request) {
        try {
            $artifacts = Http::retry(3, 200)->get('https://genshin.jmp.blue/artifacts')->json();
            foreach ($artifacts as $artifact) {
                
                $apiIdExist = Artifact::where('api_id', $artifact)->first();
    
                if (!$apiIdExist) {
                    
                    $artifactInfo = Http::retry(3, 200)->get('https://genshin.jmp.blue/artifacts/'.$artifact)->json();
                        
                    $artifactExist = Artifact::where('name', $artifactInfo['name'])->first();
                    $imgUrl = 'https://genshin.jmp.blue/artifacts/';
                    if (!$artifactExist) {
                        Artifact::create([
                            'name' => $artifactInfo['name'],
                            'api_id' => $artifact,
                            '4set' => $artifactInfo['4-piece_bonus'] ?? 'ERROR',
                            '2set' => $artifactInfo['2-piece_bonus'] ?? 'ERROR',
                        ]);
                    }
                }
            }
            
            return response()->json([
                'artifactInfo' => $artifactInfo,
                'success' => true,
                'message' => 'Artifacts Added Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addArtifactsAI(Request $request) {
        try {
         
            $perks2 = Perk::limit(100)->offset(0)->get(['id', 'name']);
            $perks1 = $perks2->pluck('name')->implode(', ');
            $artifact = Artifact::where('id', $request->id)->first();
            $text = $artifact['4set'];
           $response = Http::post('http://localhost:11434/api/generate', [
                'model' => 'dolphin-mistral',
                //   'prompt' => "Read the text of artifact {$text} and list all buffs , if buff exist in {$perks2} better , return only rel"
                'prompt' => "Classify the following genshin impact artifacts into the buffs provided. Return only the relevant buffs separated by commas.
                            artifact:
                            {$artifact->name}

                            Available buffs: {$perks1} 
                            Return: "
            ]);

            $rawBody = $response->body();

            // Split by lines and parse each as JSON
            $lines = explode("\n", trim($rawBody));
            $fullResponse = '';

            // Collect all 'response' chunks
            foreach ($lines as $line) {
                if (Str::of($line)->trim()->isEmpty()) continue;

                $jsonLine = json_decode($line, true);
                if (isset($jsonLine['response'])) {
                    $fullResponse .= $jsonLine['response'];
                }
            }


            // Split into an array by commas
            $perksArray = array_map('trim', explode(',', $fullResponse));
       
            $matchedPerks = collect($perksArray)->map(function ($perkName) use ($perks2) {
                $matchedPerk = $perks2->first(function ($perk) use ($perkName) {
                    return strtolower($perk->name) === strtolower($perkName);
                });

                return [
                    'id' => $matchedPerk->id ?? null,
                    'name' => $perkName,
                ];
            });
            
            return response()->json([
                'success' => true,
                'matchedPerks' => $matchedPerks,
                'text' => $text,
                'fullResponse' => $fullResponse,
                '$perksArray' => $perksArray,
                'message' => 'AI run  Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
