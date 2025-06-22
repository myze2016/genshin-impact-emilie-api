<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyArtifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'artifact_id',
        'party_character_id',
        'created_at',
        'updated_at',
    ];

    
    protected $table = 'party_artifact';
    
    public function artifact()
    {
        return $this->belongsTo(Artifact::class, 'artifact_id');
    }

      public function party_character()
    {
        return $this->belongsTo(PartyPositionCharacter::class, 'party_character_id');
    }

     public function stat_line()
    {
        return $this->hasMany(StatLine::class, 'party_artifact_id', 'id');
    }

     public function party_artifact_piece()
    {
        return $this->hasMany(PartyArtifactPiece::class, 'party_artifact_id', 'id');
    }
   
}
