<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'party_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'party_users';

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
