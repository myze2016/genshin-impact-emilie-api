<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyArtifactPiece extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'party_artifact_id',
         'stat_id',
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

     public function sub_stat()
    {
        return $this->hasMany(StatLineSubstat::class, 'stat_line_id', 'id');
    }

}
