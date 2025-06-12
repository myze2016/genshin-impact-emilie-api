<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Element;
use App\Models\Artifact;
use App\Models\CharacterArtifact;

class ArtifactController extends Controller
{
     public function index(Request $request) {
        $artifacts = Artifact::where('name', 'LIKE', '%'.$request->search.'%')->with('perks.perk')->paginate($request->rows_per_page ?? 10);
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
        })->with('perks.perk')->paginate($request->rows_per_page ?? 10);
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
}
