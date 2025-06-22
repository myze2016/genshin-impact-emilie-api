<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatLineSubstat extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_id',
        'party_artifact_id',
        'created_at',
        'updated_at',
    ];

    public function stat()
    {
        return $this->belongsTo(Stat::class, 'stat_id');
    }

    public function party_artifact()
    {
        return $this->belongsTo(PartyArtifact::class, 'party_artifact_id');
    }

}
