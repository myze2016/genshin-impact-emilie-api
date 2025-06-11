<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterPerk extends Model
{
    use HasFactory;

    protected $fillable = [
        'artifact_id',
        'perk_id',
        'created_at',
        'updated_at',
    ];

   
}
