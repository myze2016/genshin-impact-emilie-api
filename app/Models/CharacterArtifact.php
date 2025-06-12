<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterArtifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'artifact_id',
        'points',
        'created_at',
        'updated_at',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function artifact()
    {
        return $this->belongsTo(Artifact::class, 'artifact_id');
    }
}
