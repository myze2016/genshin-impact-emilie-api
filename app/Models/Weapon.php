<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(WeaponPerk::class, 'weapon_id');
    }
}
