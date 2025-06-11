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
}
