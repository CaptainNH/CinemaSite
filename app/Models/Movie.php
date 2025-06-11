<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // По умолчанию таблица 'movies' и ключ 'id', если иначе — раскомментируйте:
    // protected $table = 'movies';
    // protected $primaryKey = 'id';

    // Поля, доступные для массового заполнения
    protected $fillable = [
        'title',
        'description',
        'image',
        'director',
        'duration_minutes',
        'release_date',
        'genre',
        'country'
    ];

    /**
     * Получить все сеансы для данного фильма
     */
    public function Sessions()
    {
        return $this->hasMany(MovieSession::class);
    }

    /**
     * Получить форматированную продолжительность фильма
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        return $hours > 0
            ? "{$hours} ч. {$minutes} мин."
            : "{$minutes} мин.";
    }

    /**
     * Получить форматированную дату выхода фильма
     */
    public function getFormattedReleaseDateAttribute()
    {
        return date('d.m.Y', strtotime($this->release_date));
    }
}
