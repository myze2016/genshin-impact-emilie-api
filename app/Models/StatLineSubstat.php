<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatLineSubstat extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_line_id',
        'stat_id',
        'created_at',
        'updated_at',
    ];

    public function stat_line()
    {
        return $this->belongsTo(StatLine::class, 'stat_line_id');
    }

    public function stat()
    {
        return $this->belongsTo(Stat::class, 'stat_id');
    }

}
