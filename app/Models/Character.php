<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'element_id',
        'api_id',
        'gacha_card_url',
        'gacha_splash_url',
        'icon_url',
        'icon_side_url',
        'namecard_background_url',
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(CharacterPerk::class, 'character_id');
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
