<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'party_id',
        'created_at',
        'updated_at',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function characters()
    {
        return $this->hasMany(PartyPositionCharacter::class, 'party_position_id');
    }

    public function characters_value()
    {
        return $this->hasMany(PartyPositionCharacter::class, 'party_position_id')->orderBy('value', 'desc');
    }
}
