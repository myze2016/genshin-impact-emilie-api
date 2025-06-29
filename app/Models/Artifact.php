<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_id',
        'ollama',
        '4set',
        '2set',
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(ArtifactPerk::class, 'artifact_id');
    }

    public function character_artifact()
    {
        return $this->hasMany(CharacterArtifact::class, 'artifact_id');
    }

    public function party_artifact()
    {
        return $this->hasMany(PartyArtifact::class, 'artifact_id');
    }

}
