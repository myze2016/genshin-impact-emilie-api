<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyPositionCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'element',
        'value',
        'party_position_id',
        'character_id',
        'created_at',
        'updated_at',
    ];

    public function party_position()
    {
        return $this->belongsTo(PartyPosition::class, 'party_position_id');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

     public function party_weapon()
    {
        return $this->hasMany(PartyWeapon::class, 'party_character_id');
    }

     public function party_artifact()
    {
        return $this->hasMany(PartyArtifact::class, 'party_character_id');
    }

}
