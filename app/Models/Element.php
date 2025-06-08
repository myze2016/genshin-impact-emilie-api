<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'color',
        'created_at',
        'updated_at',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function parties()
    {
        return $this->hasMany(Party::class);
    }

}
