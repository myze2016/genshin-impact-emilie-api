<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'element',
        'reaction',
        'created_at',
        'updated_at',
    ];

    public function positions()
    {
        return $this->hasMany(PartyPosition::class, 'party_id');
    }
}
