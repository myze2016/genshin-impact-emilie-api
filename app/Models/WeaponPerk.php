<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponPerk extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_id',
        'perk_id',
        'points',
        'created_at',
        'updated_at',
    ];

    protected $table = 'weapon_perks';

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id');
    }

    public function perk()
    {
        return $this->belongsTo(Perk::class, 'perk_id');
    }

}
