<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'element',
        'api_id',
        'gacha_card_url',
        'gacha_splash_url',
        'icon_url',
        'icon_side_url',
        'namecard-background_url',
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(CharacterPerk::class, 'character_id');
    }
}
