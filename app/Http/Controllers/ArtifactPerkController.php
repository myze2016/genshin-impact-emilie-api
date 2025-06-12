<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CharacterPerk;
use App\Models\Perk;
use App\Models\WeaponPerk;
use App\Models\Weapon;
use App\Models\Artifact;
use App\Models\ArtifactPerk;
use Illuminate\Support\Facades\Log;

class ArtifactPerkController extends Controller
{
    public function index(Request $request) {

       $perks = Perk::with(['artifact_perks' => function ($query) use ($request) {
            $query->where('artifact_id', $request->artifact_id);
        }])
        ->withCount(['artifact_perks as related_perks_count' => function ($query) use ($request) {
            $query->where('artifact_id', $request->artifact_id);
        }])
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->orderByDesc('related_perks_count')
        ->paginate($request->rows_per_page ?? 10);

        return response()->json([
            'artifact_perks' => $perks,
            'success' => true,
            'message' => 'Artifact Perks Fetched Successfully'
        ], 200);
    }

    public function show(Request $request) {
        
    }

    public function store(Request $request) {
        $artifactPerks = ArtifactPerk::create($request->all());
        return response()->json([
            'artifact_perks' => $artifactPerks,
            'success' => true,
            'message' => 'Artifact Added Successfully'
        ], 200);
    }

    public function update(Request $request) {
        
    }

    public function destroy(Request $request) {
    }
}
