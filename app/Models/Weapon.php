<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'weapon_type_id',
        'api_id',
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(WeaponPerk::class, 'weapon_id');
    }

    public function weapon_type()
    {
        return $this->belongsTo(WeaponType::class, 'weapon_type_id');
    }

     public function character_weapon()
    {
        return $this->hasMany(CharacterWeapon::class, 'weapon_id');
    }

      public function party_weapon()
    {
        return $this->hasMany(PartyWeapon::class, 'weapon_id');
    }
}
