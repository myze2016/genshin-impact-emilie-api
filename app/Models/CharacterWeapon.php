<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterWeapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'weapon_id',
        'points',
        'created_at',
        'updated_at',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }
}
