<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieSession extends Model
{
    use HasFactory;

    protected $table = 'movie_sessions';

    protected $fillable = [
        'movie_id',
        'session_datetime',
        'price',
    ];

    /**
     * Get the movie that owns the session.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    /**
     * Get the tickets for the movie session.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'movie_session_id');
    }

    /**
     * Scope a query to only include sessions for a specific movie.
     */
    public function scopeForMovie($query, $movieId)
    {
        return $query->where('movie_id', $movieId);
    }

    /**
     * Scope a query to only include future sessions.
     */
    public function scopeFuture($query)
    {
        return $query->where('session_datetime', '>', now());
    }

    /**
     * Check if the session has available seats.
     */
    public function hasAvailableSeats()
    {
        // Logic to check if there are available seats
        // This is a placeholder - implement based on your ticket/seat system
        return $this->tickets()->count() < 100; // Example: assuming 100 seats per session
    }

    /**
     * Get the number of available seats.
     */
    public function getAvailableSeatsCount()
    {
        // Logic to calculate available seats
        // This is a placeholder - implement based on your ticket/seat system
        return 100 - $this->tickets()->count(); // Example: assuming 100 seats per session
    }
}
