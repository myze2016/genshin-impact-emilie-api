<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'element_id',
        'reaction',
        'character_id',
        'created_at',
        'updated_at',
    ];

    public function positions()
    {
        return $this->hasMany(PartyPosition::class, 'party_id');
    }

    public function character()
    {
        return $this->belongsTo(character::class, 'character_id');
    }

    public function element()
    {
        return $this->belongsTo(character::class, 'character_id');
    }
}
