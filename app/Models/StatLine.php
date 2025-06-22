<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'sands',
        'goblet',
        'circlet',
        'party_artifact_id',
        'created_at',
        'updated_at',
    ];

    public function sands_stat()
    {
        return $this->belongsTo(Stat::class, 'sands');
    }

    public function goblet_stat()
    {
        return $this->belongsTo(Stat::class, 'goblet');
    }

    public function circlet_stat()
    {
        return $this->belongsTo(Stat::class, 'circlet');
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
