<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterPerk extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'perk_id',
        'points',
        'created_at',
        'updated_at',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class, 'id', 'character_id');
    }

    public function perk()
    {
        return $this->belongsTo(Perk::class, 'id', 'perk_id');
    }
}
