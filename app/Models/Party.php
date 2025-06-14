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
        'copied_from_id',
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
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function users()
    {
        return $this->hasMany(PartyUser::class, 'party_id');
    }

    public function copied_from()
    {
        return $this->belongsTo(Party::class, 'copied_from_id');
    }
}
