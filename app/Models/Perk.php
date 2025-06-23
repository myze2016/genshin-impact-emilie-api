<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'common_id',
        'type',
        'created_at',
        'updated_at',
    ];

    public function positions()
    {
        return $this->hasMany(PartyPosition::class, 'party_id');
    }

    public function character_perks()
    {
        return $this->hasMany(CharacterPerk::class, 'perk_id');
    }

    public function weapon_perks()
    {
        return $this->hasMany(WeaponPerk::class, 'perk_id');
    }

    public function common()
    {
        return $this->belongsTo(Common::class, 'common_id');
    }

    public function artifact_perks()
    {
        return $this->hasMany(ArtifactPerk::class, 'perk_id');
    }
}
