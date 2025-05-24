<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';

    protected $fillable = [
        'movie_id',
        'session_datetime',
        'price',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
