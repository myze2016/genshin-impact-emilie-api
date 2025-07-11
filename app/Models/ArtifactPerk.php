<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtifactPerk extends Model
{
    use HasFactory;

    protected $fillable = [
        'artifact_id',
        'perk_id',
        'created_at',
        'updated_at',
    ];

    
    public function artifact()
    {
        return $this->belongsTo(Artifact::class, 'artifact_id');
    }

    public function perk()
    {
        return $this->belongsTo(Perk::class, 'perk_id');
    }
   
}
