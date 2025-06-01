<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyPositionCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'element',
        'value',
        'party_position_id',
        'created_at',
        'updated_at',
    ];

    public function party_position()
    {
        return $this->belongsTo(PartyPosition::class, 'id', 'party_position_id');
    }

    public function characters()
    {
        return $this->hasMany(PartyPositionCharacter::class, 'party_id');
    }
}
