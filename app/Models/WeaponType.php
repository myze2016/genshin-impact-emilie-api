<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'color',
        'created_at',
        'updated_at',
    ];

    public function weapon_type()
    {
        return $this->hasOne(Weapon::class, 'weapon_type_id');
    }

    
      public function characters()
    {
        return $this->hasMany(Character::class);
    }

}
