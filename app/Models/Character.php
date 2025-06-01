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
        'created_at',
        'updated_at',
    ];

    public function perks()
    {
        return $this->hasMany(CharacterPerk::class, 'character_id');
    }
}
