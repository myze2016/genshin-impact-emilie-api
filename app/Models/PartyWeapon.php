<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyWeapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_id',
        'party_character_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'party_weapon';

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }

    public function party_character()
    {
        return $this->belongsTo(PartyPositionCharacter::class, 'party_character_id');
    }

}
