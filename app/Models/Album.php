<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';

    protected $fillable = [
        'title',
        'image',
        'total_tracks',
        'artist_id'
    ];


    //relacion - un album tiene muchas canciones
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
    // relacion - un album pertenece a un artista
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}